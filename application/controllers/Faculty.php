<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faculty extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('userModel');
        $this->load->model('dbmodel');
        $this->load->model('facultyModel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }
    
    
    public function index()
    {
        redirect('faculty/view', 'refresh');
    }
    
    public function view()
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $config = array();
            $config["base_url"] = base_url() . "faculty/view";
            $config["total_rows"] = $this->facultyModel->record_count_all_faculty();
            $config["per_page"] = 25;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["num_links"] = $config["total_rows"] / $config["per_page"];
            $data['faculty'] = $this->facultyModel->get_all_faculty_info($config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();

           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/faculty/listAll', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function addNew()
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/faculty/addNew');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function addfaculty() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('facultyName', 'Faculty Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->addNew();
            } else {

                $facultyName = $this->input->post('facultyName');
               
                $this->facultyModel->add_new_faculty($facultyName);
                
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Faculty added successfully.</div>');
                
                return redirect('faculty/view', 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function edit($id)
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $data['faculty'] = $this->facultyModel->get_faculty_info_by_faculty_id($id);
           $this->load->view('dashboard/templates/header', $data);
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/faculty/edit');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function updateFaculty()
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $id =  $this->input->post('facultyId');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('facultyName', 'Faculty Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            } else {

                $facultyName = $this->input->post('facultyName');
               
                $this->facultyModel->update_faculty($id, $facultyName);
                
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Faculty updated successfully.</div>');
                
                return redirect('faculty/view', 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    
    public function delete($id)
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) { 
            $programCheck = $this->facultyModel->check_if_any_program_is_in_faculty($id);
if(empty($programCheck)){
    $result = $this->facultyModel->delete_faculty($id);
            if ($result == true) {
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Faculty deleted successfully.</div>');
               return redirect('faculty/view', 'refresh');
            } else {
                $this->session->set_flashdata("message", '<div class="alert alert-warning" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>Something went wrong.</div>');
                return redirect('faculty/view', 'refresh');
            }
    
}   else{
     $this->session->set_flashdata("message", '<div class="alert alert-warning" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>This faculty contains programs related to it. So delete related programs first.</div>');
                return redirect('faculty/view', 'refresh');
}         
            
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    





    public function xss_clean($str = NULL) {
        if ($this->security->xss_clean($str, TRUE) === FALSE) {
            $this->form_validation->set_message('xss_clean', 'The %s is invalid charactor');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    
}