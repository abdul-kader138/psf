<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 22-Apr-20
 * Time: 5:22 PM
 */

class Farmer_analysis extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/farmer_document/';
        $this->thumbs_path = 'assets/uploads/farmer_document/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1024';
        $this->permission_details = $this->site->checkPermissions();
        $this->load->library('form_validation');
        $this->load->admin_model('farmer_analysis_model');
    }

    function index()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['farmer_analysis-index'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Farmer_Analysis')));
        $meta = array('page_title' => lang('Farmer_Analysis'), 'bc' => $bc);
        $this->page_construct('farmer_analysis/index', $meta, $this->data);
    }


    function getAnalysis()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['farmer_analysis-index'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        if ($get_permission['farmer_analysis-status_update'] || $this->Owner || $this->Admin) $approve_link = '&nbsp;&nbsp;&nbsp;<span class="row_approve_status" id="$1">&nbsp;&nbsp;<i class="fa fa-th"></i> Verify Visit</span>';

        if ($get_permission['farmer_analysis-delete'] || $this->Owner || $this->Admin) $delete_link = "<a href='#' class='po' title='<b>" . lang("Delete") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . admin_url('farmer_analysis/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('Delete') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $delete_link . '</li>
            <li>' . $approve_link . '</li>
        </ul>
    </div></div>';
        $current_users = $this->farmer_analysis_model->getUsersByID($this->session->userdata('user_id'));
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('farmer_analysis') . ".id as ids, " . $this->db->dbprefix('farmer_analysis') . ".type_of_bird," . $this->db->dbprefix('farmer_analysis') . ".name," . $this->db->dbprefix('farmer_analysis') . ".mobile_no," . $this->db->dbprefix('users') . ".first_name," . $this->db->dbprefix('farmer_analysis') . ".visit_date," . $this->db->dbprefix('zones') . ".name as zname," . $this->db->dbprefix('farmer_analysis') . ".fcr," . $this->db->dbprefix('farmer_analysis') . ".mortality,round(" . $this->db->dbprefix('farmer_analysis') . ".mortality_per,2) as per," . $this->db->dbprefix('farmer_analysis') . ".feed_intake," . $this->db->dbprefix('farmer_analysis') . ".body_weight," . $this->db->dbprefix('farmer_analysis') . ".egg_production," . $this->db->dbprefix('farmer_analysis') . ".verified_status")
            ->from("farmer_analysis")
            ->join('zones', 'farmer_analysis.zone_id=zones.id', 'left')
            ->join('users', 'farmer_analysis.created_by=users.id', 'left');
        if (!$this->Owner && !$this->Admin && $current_users->view_right == '0') {
            $this->datatables->where('farmer_analysis.created_by', $this->session->userdata('user_id'));
        }
        $this->datatables->add_column("Actions", $action, "ids");
        echo $this->datatables->generate();
    }

    public function add()
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['farmer_analysis-add'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->load->helper('security');
        $this->form_validation->set_rules('file_path', lang("Upload_File"), 'xss_clean');
        $this->form_validation->set_rules('type_of_bird', lang("Type_Of_Bird"), 'trim|required');
        $this->form_validation->set_rules('zone_id', lang("Zone"), 'trim|required');
        $this->form_validation->set_rules('visit_date', lang("Visit Date"), 'trim|required');
        $this->form_validation->set_rules('initial_qty', lang("Initial Quantity"), 'trim|required');
        $this->form_validation->set_rules('name', lang("Farmer Name"), 'trim|required');
        $this->form_validation->set_rules('area', lang("Area"), 'trim|required');
        $this->form_validation->set_rules('age', lang("Age"), 'trim|required');
        $this->form_validation->set_rules('hatch_date', lang("Hatch Date"), 'trim|required');
        $this->form_validation->set_rules('hatchery', lang("Hatchery"), 'trim|required');
        $this->form_validation->set_rules('breed', lang("Breed"), 'trim|required');
        $this->form_validation->set_rules('mortality', lang("Mortality"), 'trim|required');
        $this->form_validation->set_rules('mobile_no', lang("Mobile_No"), 'trim|required|regex_match[/^\+?[0-9-()]+$/]');
        $this->form_validation->set_rules('feed_intake', lang("Feed Intake"), 'trim|required');
        $this->form_validation->set_rules('body_weight', lang("Body_Weight"), 'trim|required');
        $this->form_validation->set_rules('fcr', lang("FCR"), 'trim|xss_clean');
        $this->form_validation->set_rules('feed_mill', lang("Feed_Mill"), 'trim|required');
        $this->form_validation->set_rules('comment', lang("Comment"), 'trim|required');
        $this->form_validation->set_rules('feed_brand', lang("Feed_Brand"), 'trim|required');
        if ($this->form_validation->run() == true) {
            $doc_link = "";
            if ($_FILES['file_path']['size'] > 0) {
                $_FILES['file']['name'] = $_FILES['file_path']['name'];
                $_FILES['file']['type'] = $_FILES['file_path']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['file_path']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['file_path']['error'];
                $_FILES['file']['size'] = $_FILES['file_path']['size'];

                $config['upload_path'] = 'assets/uploads/farmer_document/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $config['max_size'] = '5000'; // max_size in kb
                $config['file_name'] = $_FILES['file_path']['name'];
                $config['encrypt_name'] = TRUE;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 20;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $uploadData = $this->upload->data();
                $doc_link = $uploadData['file_name'];
            }

            $data = array(
                'type_of_bird' => $this->input->post('type_of_bird'),
                'zone_id' => $this->input->post('zone_id'),
                'visit_date' => $this->sma->fsd($this->input->post('visit_date')),
                'hatch_date' => $this->sma->fsd($this->input->post('hatch_date')),
                'name' => $this->input->post('name'),
                'area' => $this->input->post('area'),
                'age' => $this->input->post('age'),
                'initial_qty' => $this->input->post('initial_qty'),
                'hatchery' => $this->input->post('hatchery'),
                'comment' => $this->input->post('comment'),
                'breed' => $this->input->post('breed'),
                'age_type' => ($this->input->post('type_of_bird') == 'Layer' ? 'Week' : 'Day'),
                'mortality' => $this->input->post('mortality'),
                'feed_intake' => $this->input->post('feed_intake'),
                'body_weight' => $this->input->post('body_weight'),
                'mortality_per' => ($this->input->post('mortality') * 100 / $this->input->post('initial_qty')),
                'fcr' => $this->input->post('fcr'),
                'egg_production' => $this->input->post('egg_production'),
                'feed_mill' => $this->input->post('feed_mill'),
                'mobile_no' => $this->input->post('mobile_no'),
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date("Y-m-d H:i:s"),
                'feed_brand' => $this->input->post('feed_brand'),
                'file_path' => $doc_link
            );
        }
        if ($this->form_validation->run() == true && $this->farmer_analysis_model->addFarmerAnalysisInfo($data)) {
            $this->session->set_flashdata('message', lang("Information_updated_successfully"));
            admin_redirect('farmer_analysis/index');
        } else {
            $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['zones'] = $this->site->getAllZones();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('farmer_analysis'), 'page' => lang('Farmer_Analysis')), array('link' => '#', 'page' => lang('Add')));
            $meta = array('page_title' => lang('Add'), 'bc' => $bc);
            $this->page_construct('farmer_analysis/add', $meta, $this->data);
        }
    }

    function modal_view($id = NULL)
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['farmer_analysis-index'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        $pr_details = $this->farmer_analysis_model->getAnalysisById($id);

        if (!$id || !$pr_details) {
            $this->session->set_flashdata('error', lang('info_not_found'));
            $this->sma->md();
        }
        $this->data['zone'] = $this->farmer_analysis_model->getZoneById($pr_details->zone_id);
        $this->data['user'] = $this->farmer_analysis_model->getUserById($pr_details->created_by);
        $this->data['analysis'] = $pr_details;
        $this->load->view($this->theme . 'farmer_analysis/modal_view', $this->data);
    }

    function delete($id = NULL)
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['farmer_analysis-delete'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $farmer_details = $this->farmer_analysis_model->getAnalysisById($id);
        if ($this->farmer_analysis_model->deleteAnalysis($id)) {
            unlink('assets/uploads/farmer_document/' . $farmer_details->file_path);
            $this->sma->send_json(array('error' => 0, 'msg' => lang("Information_Deleted_Successfully.")));
        } else {
            $this->sma->send_json(array('error' => 1, 'msg' => lang("Operation_Not_Success")));
        }
    }

    public function update_status($id)
    {
        if (!$this->Owner && !$this->Admin) {
            $get_permission = $this->permission_details[0];
            if ((!$get_permission['farmer_analysis-status_update'])) {
                $this->session->set_flashdata('warning', lang('access_denied'));
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        $this->form_validation->set_rules('status', lang("Status"), 'required');
        if ($this->form_validation->run() == true) {
            $status = $this->input->post('status');
            $note = $this->sma->clear_tags($this->input->post('note'));
        } elseif ($this->input->post('update')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'farmer_analysis');
        }
        if ($this->form_validation->run() == true && $this->farmer_analysis_model->updateStatus($id, $status, $note)) {
            $this->session->set_flashdata('message', lang('Status_updated_successfully.'));
            admin_redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'farmer_analysis');
        } else {
            $this->data['analysis'] = $this->farmer_analysis_model->getAnalysisById($id);
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'farmer_analysis/update_status', $this->data);
        }
    }

}