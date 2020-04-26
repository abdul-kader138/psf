<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: a.kader
 * Date: 24-Feb-20
 * Time: 10:56 AM
 */

class Competitor_analysis extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        $this->permission_details = $this->site->checkPermissions();
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1024';
        $this->permission_details = $this->site->checkPermissions();
        $this->load->library('form_validation');
        $this->load->admin_model('competitor_analysis_model');
    }


    public function zone_add_sales()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_target-zone_add'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');
        $this->form_validation->set_rules('um', lang("um"), 'trim|required');
        $this->form_validation->set_rules('bu', lang("bu"), 'trim|required');
        $this->form_validation->set_rules('year', lang("year"), 'trim|required');
        $this->form_validation->set_rules('month', lang("month"), 'trim|required');
        $this->form_validation->set_rules('category_id', lang("category_id"), 'trim|required');

        if ($this->form_validation->run() == true) {

            $month = $this->input->post('month');
            $category_id = $this->input->post('category_id');
            $year = $this->input->post('year');
            $um = $this->input->post('um');
            $bu = $this->input->post('bu');

            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = true;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    admin_redirect("sales_target/zone_add");
                }

                $csv = $this->upload->file_name;
                $data['attachment'] = $csv;

                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                $keys = array('company','zone_code', 'quantity');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;

                foreach ($final as $csv_pr) {
                    if (isset($csv_pr['zone_code']) && isset($csv_pr['quantity']) && isset($csv_pr['company'])) {

                        $bill_details=null;

                        $bill_details = $this->competitor_analysis_model->getCompetitorData($month, $year, $category_id,$csv_pr['zone_code'], $bu);
                        if ($bill_details) {
                            $this->session->set_flashdata('error', lang("Target_already_exist"));
                            redirect($_SERVER["HTTP_REFERER"]);
                        }

                        $target_details = $this->competitor_analysis_model->getCompanyByName($csv_pr['company']);
                        if (!$target_details) {
                            $this->session->set_flashdata('error', lang("Company")  . "not found");
                            redirect($_SERVER["HTTP_REFERER"]);
                        }

                        $target_details = $this->competitor_analysis_model->getZoneByCode($csv_pr['zone_code']);
                        if (!$target_details) {
                            $this->session->set_flashdata('error', lang("Zone_Code")  . "not found");
                            redirect($_SERVER["HTTP_REFERER"]);
                        }
                        $target_quantity = 0;
                        $zone=$this->site->getZoneByCode($csv_pr['zone_code']);
                        if ($target_details) {
                            $dues = 0;
                            $target_quantity = (float)$csv_pr['quantity'];
                            $zones_data[] = array(
                                'reference_no' => ($year . "_" . $month . "_" . $category_id . "_"  . $bu),
                                'year' => $year,
                                'month' => $month,
                                'category_id' => $category_id,
                                'business_unit' => $bu,
                                'um' => $um,
                                'zone_code' => $csv_pr['zone_code'],
                                'company' => $csv_pr['company'],
                                'zone_name' => $zone->name,
                                'quantity' => $target_quantity,
                                'created_by' => $this->session->userdata('user_id'),
                                'created_date' => date("Y-m-d H:i:s")
                            );
                        }
                        // csv data check


                        $t=4;
                    }
                }

            }
        }


        if ($this->form_validation->run() == true && $this->competitor_analysis_model->addCompetitorAnalysis($zones_data)) {
            $this->session->set_flashdata('message', lang("bill_added"));
            admin_redirect('competitor_analysis/zones_list');
        } else {

            $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['units'] = $this->site->getAllBaseUnits();
            $this->data['categories'] = $this->site->getAllCategories();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales_target'), 'page' => lang('Sales_Target')), array('link' => '#', 'page' => lang('Zone')));
            $meta = array('page_title' => lang('Add_Zones_Target'), 'bc' => $bc);
            $this->page_construct('competitor_analysis/zone_add_sales', $meta, $this->data);

        }
    }

    function zones_list()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_target-zones'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Zones_Target')));
        $meta = array('page_title' => lang('Zones_Target'), 'bc' => $bc);
        $this->page_construct('competitor_analysis/zones_list', $meta, $this->data);
    }

    function getZonesList()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_target-zones'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        if ($get_permission['sales_target-delete_zone_target'] || $this->Owner || $this->Admin) $delete_link = "<a href='#' class='po' title='<b>" . lang("Delete") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . admin_url('competitor_analysis/delete_zone_list/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('Delete') . "</a>";
        $detail_link = anchor('admin/competitor_analysis/competitor_details/$1', '<i class="fa fa-file-text-o"></i> ' . lang('Competitor_Details'));
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
            <li>' . $delete_link . '</li>
        </ul>
    </div></div>';
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('competitor_analysis') . ".reference_no as id, ". $this->db->dbprefix('competitor_analysis') . ".business_unit," . $this->db->dbprefix('categories') . ".name as c_name," . $this->db->dbprefix('competitor_analysis') . ".company,round(sum(" . $this->db->dbprefix('competitor_analysis') . ".quantity)/1000,2) as u_amount," . $this->db->dbprefix('competitor_analysis') . ".month," . $this->db->dbprefix('competitor_analysis') . ".year")
            ->from("competitor_analysis")
            ->join('categories', 'competitor_analysis.category_id=categories.id', 'left')
            ->group_by('competitor_analysis.year,competitor_analysis.month,categories.name,competitor_analysis.company')
            ->edit_column('active', '$1__$2', 'active, id')
            ->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }




    function delete_zone_list($id = NULL)
    {
        if (!$this->Owner) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_target-delete_zone_target'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->competitor_analysis_model->deleteCompetitorAnalysis($id)) {
            if ($this->input->is_ajax_request()) {
                echo lang("Info_Deleted");
                die();
            }
            $this->session->set_flashdata('message', lang('Info_Deleted_Successfully'));
            admin_redirect('competitor_analysis/zones_list');
        }
    }


    public function competitor_details($bill_id = null)
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_target-zones'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        if ($this->input->get('id')) {
            $bill_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $info = $this->competitor_analysis_model->competitor_details($bill_id);
        $this->data['id'] = $bill_id;
        $this->data['rows'] = $info;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('Sales_Target')), array('link' => '#', 'page' => lang('View_Target_Details')));
        $meta = array('page_title' => lang('View_Competitor_Details'), 'bc' => $bc);
        $this->page_construct('competitor_analysis/competitor_details', $meta, $this->data);

    }

}