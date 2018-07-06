<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('userModel');
        $this->load->model('dbmodel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                // $loginDatetime = $userDet->last_login_date;
            }

           
            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/dashboard/mainPage');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function contactMessage() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->dbuser->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                $loginDatetime = $userDet->last_login_date;
            }

            
            $config = array();
            $config["base_url"] = base_url() . "event/index";
            $config["total_rows"] = $this->dbmodel->record_count_all_contact_message();
            $config["per_page"] = 25;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["num_links"] = $config["total_rows"] / $config["per_page"];
            $data['records'] = $this->dbmodel->get_all_contact_message($config["per_page"], $page);


            $data["links"] = $this->pagination->create_links();

            $this->load->view('dashboard/templates/header', $data);
            $this->load->view('dashboard/templates/sideNavigation', $data);
            $this->load->view('dashboard/template/navigation');
            $this->load->view('dashboard/contact/contactList');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

}
