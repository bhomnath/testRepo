<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Program extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('userModel');
        $this->load->model('dbmodel');
        $this->load->model('facultyModel');
        $this->load->model('programModel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        redirect('program/view', 'refresh');
    }
    
    public function view()
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $config = array();
            $config["base_url"] = base_url() . "program/view";
            $config["total_rows"] = $this->programModel->record_count_all_program();
            $config["per_page"] = 25;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["num_links"] = $config["total_rows"] / $config["per_page"];
            $data['program'] = $this->programModel->get_all_program_info($config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();

           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/program/listAll', $data);
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
            
            $data['faculty'] = $this->facultyModel->get_list_of_faculty();
           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/program/addNew', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function addprogram() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('facultyName', 'Faculty Name', 'trim|regex_match[/^[a-z,0-9,A-Z\ ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('programNameShort', 'Program Name in Short', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('programNameFull', 'Program Name in Full', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->addNew();
            } else {

                $facultyName = $this->input->post('facultyName');
                
                $programNameShort = $this->input->post('programNameShort');
                $programNameFull = $this->input->post('programNameFull');
               
                $this->programModel->add_new_program($facultyName, $programNameShort, $programNameFull);
                
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Program added successfully.</div>');
                
                return redirect('program/view', 'refresh');
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
            
            $data['faculty'] = $this->facultyModel->get_list_of_faculty();
            $data['program'] = $this->programModel->get_program_info_by_program_id($id);
           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/program/edit', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
     public function updateProgram() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $id =  $this->input->post('programId');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('facultyName', 'Faculty Name', 'trim|regex_match[/^[a-z,0-9,A-Z\ ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('programNameShort', 'Program Name in Short', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('programNameFull', 'Program Name in Full', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            } else {

                $facultyName = $this->input->post('facultyName');
                
                $programNameShort = $this->input->post('programNameShort');
                $programNameFull = $this->input->post('programNameFull');
               
                $this->programModel->update_program($id, $facultyName, $programNameShort, $programNameFull);
                
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Program updated successfully.</div>');
                
                return redirect('program/view', 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function delete($id)
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) { 
            $subjectCheck = $this->programModel->check_if_any_subject_is_in_program($id);
if(empty($subjectCheck)){
   $result = $this->programModel->delete_program($id);
            if ($result == true) {
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Program deleted successfully.</div>');
               return redirect('program/view', 'refresh');
            } else {
                $this->session->set_flashdata("message", '<div class="alert alert-warning" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>Something went wrong.</div>');
                return redirect('program/view', 'refresh');
            }
    
}   else{
     $this->session->set_flashdata("message", '<div class="alert alert-warning" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>This program contains subject related to it. So delete related subject first.</div>');
                return redirect('program/view', 'refresh');
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