<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: a.kader
 * Date: 16-Sep-19
 * Time: 3:38 PM
 */
class Sales_achievement extends MY_Controller
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
        $this->load->admin_model('sales_achievement_model');
    }


    public function sales_officer_add()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_achievement-sales_officer_add'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                admin_redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');
        $this->form_validation->set_rules('um', lang("um"), 'trim|required');
        $this->form_validation->set_rules('bu', lang("bu"), 'trim|required');
        $this->form_validation->set_rules('year', lang("year"), 'trim|required');
        $this->form_validation->set_rules('month', lang("month"), 'trim|required');
        $this->form_validation->set_rules('category_id', lang("category_id"), 'trim|required');
        $this->form_validation->set_rules('zone_id', lang("zone_id"), 'trim|required');

        if ($this->form_validation->run() == true) {

            $month = $this->input->post('month');
            $category_id = $this->input->post('category_id');
            $zone_id = $this->input->post('zone_id');
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
                    admin_redirect("sales_achievement/sales_officer_add");
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

                $keys = array('user_code', 'sale_quantity', 'dealer', 'no_of_visit','sales_amount','credit_amount');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;

                foreach ($final as $csv_pr) {
                    if (isset($csv_pr['user_code']) && isset($csv_pr['sale_quantity'])) {

                        $bill_details = null;

                        $bill_details = $this->sales_achievement_model->getSalesOfficerAchievement($month, $year, $category_id, $zone_id, $bu,$csv_pr['user_code']);
                        if ($bill_details) {
                            $this->session->set_flashdata('error', lang("Data_already_exist"));
                            redirect($_SERVER["HTTP_REFERER"]);
                        }

                        $target_details = $this->sales_achievement_model->getUserByCode($csv_pr['user_code']);
                        if (!$target_details) {
                            $this->session->set_flashdata('error', lang("user_code") . "not found");
                            redirect($_SERVER["HTTP_REFERER"]);
                        }

                        $target_quantity = 0;
                        if ($target_details) {
                            $dues = 0;
                            $target_quantity = (float)$csv_pr['sale_quantity'];
                            $target[] = array(
                                'reference_no' => ($year . "_" . $month . "_" . $category_id . "_" . $zone_id . "_" . $bu),
                                'year' => $year,
                                'month' => $month,
                                'category_id' => $category_id,
                                'business_unit' => $bu,
                                'um' => $um,
                                'user_code' => $csv_pr['user_code'],
                                'zone_id' => $zone_id,
                                'dealer' => $csv_pr['dealer'],
                                'no_of_visit' => $csv_pr['no_of_visit'],
                                'sales_amount' => $csv_pr['sales_amount'],
                                'credit_amount' => $csv_pr['credit_amount'],
                                'quantity' => $target_quantity,
                                'created_by' => $this->session->userdata('user_id'),
                                'created_date' => date("Y-m-d H:i:s")
                            );
                        }
                        // csv data check
                    }
                }

            }
        }


        if ($this->form_validation->run() == true && $this->sales_achievement_model->addSalesOfficerAchv($target)) {
            $this->session->set_flashdata('message', lang("Info_Added"));
            admin_redirect("sales_achievement/sales_officer");
        } else {

            $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['units'] = $this->site->getAllBaseUnits();
            $this->data['zones'] = $this->site->getAllZones();
            $this->data['categories'] = $this->site->getAllCategories();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales_achievement'), 'page' => lang('Sales_Achievement')), array('link' => '#', 'page' => lang('Sales_Officer')));
            $meta = array('page_title' => lang('Add_Sales_Achievement'), 'bc' => $bc);
            $this->page_construct('sales_achievement/sales_officer_add', $meta, $this->data);

        }
    }


    function sales_officer()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_achievement-sales_officer'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Sales_Officer_Achievement')));
        $meta = array('page_title' => lang('Sales_Officer_Achievement'), 'bc' => $bc);
        $this->page_construct('sales_achievement/sales_officer', $meta, $this->data);
    }

    function getSalesOfficer()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_achievement-sales_officer'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        if ($get_permission['sales_achievement-delete_sales_officer'] || $this->Owner || $this->Admin) $delete_link = "<a href='#' class='po' title='<b>" . lang("Delete") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . admin_url('sales_achievement/delete_sales_officer/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('Delete') . "</a>";
        $detail_link = anchor('admin/sales_achievement/sales_officer_details/$1', '<i class="fa fa-file-text-o"></i> ' . lang('Details'));
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
            ->select($this->db->dbprefix('sales_officer_achievement') . ".reference_no as id, " . $this->db->dbprefix('sales_officer_achievement') . ".business_unit," . $this->db->dbprefix('categories') . ".name as c_name," . $this->db->dbprefix('zones') . ".name as zname,sum(" . $this->db->dbprefix('sales_officer_achievement') . ".dealer) as dealers,round(sum(" . $this->db->dbprefix('sales_officer_achievement') . ".quantity),2) as u_amount,round(sum(" . $this->db->dbprefix('sales_officer_achievement') . ".credit_amount),2) as c_amount," . $this->db->dbprefix('sales_officer_achievement') . ".month," . $this->db->dbprefix('sales_officer_achievement') . ".year")
            ->from("sales_officer_achievement")
            ->join('categories', 'sales_officer_achievement.category_id=categories.id', 'left')
            ->join('zones', 'sales_officer_achievement.zone_id=zones.id', 'left')
            ->group_by('sales_officer_achievement.year,sales_officer_achievement.month,categories.name,zones.name')
            ->edit_column('active', '$1__$2', 'active, id')
            ->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }

    public function sales_officer_details($bill_id = null)
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_achievement-sales_officer'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                admin_redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        if ($this->input->get('id')) {
            $bill_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $info = $this->sales_achievement_model->getAllOfficersTargetDetails($bill_id);
        $this->data['id'] = $bill_id;
        $this->data['rows'] = $info;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('Sales_Target')), array('link' => '#', 'page' => lang('View_Target_Details')));
        $meta = array('page_title' => lang('View_Details'), 'bc' => $bc);
        $this->page_construct('sales_achievement/details', $meta, $this->data);

    }


    function delete_sales_officer($id = NULL)
    {
        if (!$this->Owner) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['sales_achievement-delete_sales_officer'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                admin_redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->sales_achievement_model->deleteZoneAchv($id)) {
            if ($this->input->is_ajax_request()) {
                echo lang("Info_Deleted");
                die();
            }
            $this->session->set_flashdata('message', lang('Info_Deleted'));
            admin_redirect('sales_achievement/sales_officer');
        }
    }
}