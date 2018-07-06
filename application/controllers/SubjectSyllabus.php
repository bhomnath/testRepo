<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SubjectSyllabus extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('userModel');
        $this->load->model('dbmodel');
        $this->load->model('facultyModel');
        $this->load->model('programModel');
        $this->load->model('subSyllModel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }
    
    
     public function index()
    {
        {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $data['faculty'] = $this->subSyllModel->get_all_faculty();
            $data["links"] = $this->pagination->create_links();
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/subjectSyllabus/listAllFaculty', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    }
    
    public function view($id)
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $config = array();
            $config["base_url"] = base_url() . "subjectSyllabus/view";
            $config["total_rows"] = $this->subSyllModel->record_count_all_subject($id);
            $config["per_page"] = 25;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config["num_links"] = $config["total_rows"] / $config["per_page"];
            $data['subject'] = $this->subSyllModel->get_all_subject_info($config["per_page"], $page, $id);
            $data["links"] = $this->pagination->create_links();

           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/subjectSyllabus/listAll', $data);
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
            $this->load->view('dashboard/subjectSyllabus/addNew', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function addsubject() {
        ini_set('memory_limit', '-1');
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $date = new DateTime("now", new DateTimeZone('Asia/Kathmandu') );
            $curDate = $date->format('Y-m-d H:i:s');
            $config['upload_path'] = './syllabus/';
            $config['allowed_types'] = 'txt|png|jpg';
            $config['max_size'] = '20000';
            $config['max_width'] = '10000';
            $config['max_height'] = '10000';
            $this->load->library('upload', $config);
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('facultyName', 'Faculty Name', 'trim|regex_match[/^[a-z,0-9,A-Z\ ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('programName', 'Program Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('subjectCode', 'Subject Code', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('subjectName', 'Subject Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('semester', 'Semester', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('credit', 'Credit Hour', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if (($this->form_validation->run() == FALSE) || (!$this->upload->do_upload('syllabusFile'))) {
                $data['error'] = $this->upload->display_errors();
                $data['faculty'] = $this->facultyModel->get_list_of_faculty();
           $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/subjectSyllabus/addNew', $data);
            $this->load->view('dashboard/templates/footer');
            } else {

                $data = array('upload_data' => $this->upload->data());
                $fileName = $data['upload_data']['file_name'];
                
                $facultyName = $this->input->post('facultyName');
                $programName = $this->input->post('programName');
                $subjectCode = $this->input->post('subjectCode');
                $subjectName = $this->input->post('subjectName');
                $semester = $this->input->post('semester');
                $credit = $this->input->post('credit');
               $flag = '1';
                $subjectId = $this->subSyllModel->add_new_subject_and_syllabus($facultyName, $programName, $subjectCode, $subjectName, $semester, $credit, $fileName);
                $this->subSyllModel->add_new_subject_and_syllabus_for_notification($facultyName, $programName, $subjectId, $curDate, $flag);
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Subject and Syllabus added successfully.</div>');
                
                return redirect('SubjectSyllabus/view/'.$programName, 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function getFacultyProgram()
    {
        if ($_POST) {
           if(isset($_POST['faculty']) && (!empty($_POST['faculty']))){
            $faculty = $_POST['faculty'];     
        }else{
            $faculty = "";
        }
        $programs = $this->programModel->get_list_of_program_by_faculty_id($faculty);
        if(!empty($programs)){
            $view = '<select class="form-control col-lg-12" name="programNameShort" id="programNameShort" required >';
            foreach ($programs as $programAll){
              $view .= '<option value="'.$programAll->id.'">'.$programAll->fullName.'</option>';  
            }
            $view .= '</select>';
            echo $view;
        }else{
            echo "";
        }
        }else{
            echo "";
        }
    }

    public function edit($id)
    {
      
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $data['faculty'] = $this->facultyModel->get_list_of_faculty();
            $data['subjectSyllabus'] = $this->subSyllModel->get_subSyllabus_info_by_subSyllabus_id($id);
            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/subjectSyllabus/edit', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    
    }
    
    public function update() {
        ini_set('memory_limit', '-1');
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
            $data['subjectInFlag'] = $this->dbmodel->get_syllabus_insert_flag();
            $data['subjectUpFlag'] = $this->dbmodel->get_syllabus_update_flag();
            
            $date = new DateTime("now", new DateTimeZone('Asia/Kathmandu') );
            $curDate = $date->format('Y-m-d H:i:s');
            $flag = '2';
            $config['upload_path'] = './syllabus/';
            $config['allowed_types'] = 'txt|png|jpg';
            $config['max_size'] = '20000';
            $config['max_width'] = '10000';
            $config['max_height'] = '10000';
            $this->load->library('upload', $config);
            $subjectId = $this->input->post('subjectId');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('facultyName', 'Faculty Name', 'trim|regex_match[/^[a-z,0-9,A-Z\ ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('programName', 'Program Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('subjectCode', 'Subject Code', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('subjectName', 'Subject Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('semester', 'Semester', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('credit', 'Credit Hour', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{1,200}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->edit($subjectId);
            } else {
                 if ($_FILES && $_FILES['file']['name'] !== "") {
                    if (!$this->upload->do_upload('file')) {
                       
                        $data['error'] = $this->upload->display_errors('file');
                         $data['faculty'] = $this->facultyModel->get_list_of_faculty();
            $data['subjectSyllabus'] = $this->subSyllModel->get_subSyllabus_info_by_subSyllabus_id($subjectId);
            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/subjectSyllabus/edit', $data);
            $this->load->view('dashboard/templates/footer');
                    } else {
                $data = array('upload_data' => $this->upload->data());
                $fileName = $data['upload_data']['file_name'];
                $facultyName = $this->input->post('facultyName');
                $programName = $this->input->post('programName');
                $subjectCode = $this->input->post('subjectCode');
                $subjectName = $this->input->post('subjectName');
                $semester = $this->input->post('semester');
                $credit = $this->input->post('credit');
               
                $this->subSyllModel->update_subject_and_syllabus_with_file($subjectId, $facultyName, $programName, $subjectCode, $subjectName, $semester, $credit, $fileName);
                $this->subSyllModel->add_new_subject_and_syllabus_for_notification($facultyName, $programName, $subjectId, $curDate, $flag);
                 }}else {
                $facultyName = $this->input->post('facultyName');
                $programName = $this->input->post('programName');
                $subjectCode = $this->input->post('subjectCode');
                $subjectName = $this->input->post('subjectName');
                $semester = $this->input->post('semester');
                $credit = $this->input->post('credit');
                $this->subSyllModel->update_subject_and_syllabus_with_out_file($subjectId, $facultyName, $programName, $subjectCode, $subjectName, $semester, $credit);      
                $this->subSyllModel->add_new_subject_and_syllabus_for_notification($facultyName, $programName, $subjectId, $curDate, $flag);
                }
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Subject and Syllabus added successfully.</div>');
                
                return redirect('SubjectSyllabus/view/'.$programName, 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }
    
    public function delete($id)
    {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            
             $syllabus = $this->subSyllModel->get_subSyllabus_info_by_subSyllabus_id($id);
            foreach ($syllabus as $a) {
                $file = $a->syllabusText;
                $subjectId = $a->subId;
            }
            if (!empty($file)) {
               $filename1 = './syllabus/'.$file;
           
if (file_exists($filename1)) {
    unlink($filename1);
} else {}
            }
        $stat = $this->subSyllModel->delete_subject_and_syllabus($subjectId);
        
         $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Subject and Syllabus deleted successfully.</div>');
                
                return redirect('SubjectSyllabus/view', 'refresh');
        
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    
    public function applyInsert() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                //$loginDatetime = $userDet->last_login_date;
            }
            
            $programIds = $this->dbmodel->get_program_id_for_syllabus_insert_info_to_database();
            if(!empty($programIds)){
                foreach($programIds as $prgs){
                    $name = $prgs->name;
            date_default_timezone_set("Asia/Kathmandu");
            $date = date("Y-m-d h:i:sa");
            $pushMessage = array('title' => "New Syllabus Added", "message" => "PU Syllabus just added a syllabus into the program you selected", 'date' => $date);

            $message_status = json_decode($this->send_notification($pushMessage, $name));
                }
            }
            if (!empty($message_status->message_id)) {
                $this->dbmodel->update_syllabus_insert_info_to_database();                
                    $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Syllabus Addition published successfully.</div>');
                    redirect('SubjectSyllabus/index', 'refresh');                
            } else {
                $this->session->set_flashdata("message", '<div class="alert alert-danger" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>Price for colorants were not published.</div>');
                redirect('SubjectSyllabus/index', 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function send_notification($pushMessage, $data) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $priority = "high";
        $notification = $pushMessage;

        $datas = array
    (
         "msg" => 'New Syllabus Added',
         "flag" => 'syllabus'
    );
        
        $fields = array(
            'to' => "/topics/".$data,
            'data' => $datas
        );
        $headers = array(
            'Authorization:key=AAAA0ylBfGk:APA91bHIsGX2SPTAGVlxLP5NLnkcFvufmmkJe68E5DNYxsA-3GpmjcngCCCO6Ezvu847fo6j4z0VXg3DfDdXJ_SUvB99dnIEZ3nYDcYPKN2_NC0aHCCogs8UdwM4rhO79uob0vmHmgkHD5KqTuQgITdUGx7_Sa26kQ',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // echo json_encode($fields);
        $result = curl_exec($ch);
        echo curl_error($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    
    
    
    public function applyUpdate() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                //$loginDatetime = $userDet->last_login_date;
            }

            $programIds = $this->dbmodel->get_program_id_for_syllabus_update_info_to_database();
            if(!empty($programIds)){
                foreach($programIds as $prgs){
                    $name = $prgs->name;
            date_default_timezone_set("Asia/Kathmandu");
            $date = date("Y-m-d h:i:sa");
            $pushMessage = array('title' => "New Syllabus Added", "message" => "PU Syllabus just added a syllabus into the program you selected", 'date' => $date);

            $message_status = json_decode($this->send_notificationUpdate($pushMessage, $name));
                }
            }
            if (!empty($message_status->message_id)) {
                $retrn = $this->dbmodel->update_syllabus_update_info_to_database();
                if ($retrn == true) {
                    $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>Syllabus Update published successfully.</div>');
                    redirect('SubjectSyllabus/index', 'refresh');
                } else {
                    $this->session->set_flashdata("message", '<div class="alert alert-danger" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>Syllabus Update were not published.</div>');
                    redirect('SubjectSyllabus/index', 'refresh');
                }
            } else {
                $this->session->set_flashdata("message", '<div class="alert alert-danger" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>Price for colorants were not published.</div>');
                redirect('SubjectSyllabus/index', 'refresh');
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function send_notificationUpdate($pushMessage, $data) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $priority = "high";
        $notification = $pushMessage;

        $datas = array
    (
         "msg" => 'Syllabus Updated',
         "flag" => 'syllabus'
    );
        
        $fields = array(
            'to' => "/topics/".$data,
            'data' => $datas
        );
        $headers = array(
            'Authorization:key=AAAA0ylBfGk:APA91bHIsGX2SPTAGVlxLP5NLnkcFvufmmkJe68E5DNYxsA-3GpmjcngCCCO6Ezvu847fo6j4z0VXg3DfDdXJ_SUvB99dnIEZ3nYDcYPKN2_NC0aHCCogs8UdwM4rhO79uob0vmHmgkHD5KqTuQgITdUGx7_Sa26kQ',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // echo json_encode($fields);
        $result = curl_exec($ch);
        echo curl_error($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
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