<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('dbcontact');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('contact/contactInfoAndForm');
    }

    public function addContact() {
        $this->load->library(array('form_validation', 'session'));
        $this->form_validation->set_rules('firstName', 'Given Name', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,100}$/]|required|callback_xss_clean|max_length[200]');
        $this->form_validation->set_rules('lastName', 'Surname', 'trim|regex_match[/^[a-z,0-9,A-Z_\-. ]{2,100}$/]|required|callback_xss_clean|max_length[200]');
        $this->form_validation->set_rules('email', 'Email', 'trim|regex_match[/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/]|required|callback_xss_clean|max_length[200]');
        $this->form_validation->set_rules('organization', 'Organization', 'trim|callback_xss_clean|max_length[200]');
        $this->form_validation->set_rules('phoneNo', 'Phone number', 'trim|callback_xss_clean|max_length[20]');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|callback_xss_clean|max_length[200]');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|callback_xss_clean|max_length[2000]');
        // $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_check_captcha');
        $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('contact/contactInfoAndForm');
        } else {
            date_default_timezone_set("Asia/Kathmandu");
            $date = date("Y-m-d h:i:sa");
            $fname = $this->input->post('firstName');
            $lname = $this->input->post('lastName');
            $email = $this->input->post('email');
            $organization = $this->input->post('organization');
            $phone = $this->input->post('phoneNo');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            $this->dbcontact->add_contact_forms_data($date, $fname, $lname, $email, $organization, $phone, $subject, $message);
            $this->contactEmail($fname, $lname, $email, $organization, $phone, $subject, $message, $date);
            $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 0;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Thank you! </strong><br/>Your message has been successfully sent. We will contact you very soon! </div>');
            redirect('contact/index');
        }
    }

    public function contactEmail($fname, $lname, $email, $organization, $phone, $subjectss, $message, $date) {
        $this->load->helper('emailsend_helper');
        $subject = $subjectss;
        $link = base_url();
        $messages = contact_email($fname, $lname, $email, $organization, $phone, $subjectss, $message, $date, $link);
        send_contact_email($email, $subject, $messages);
    }

    public function xss_clean($str) {
        if ($this->security->xss_clean($str, TRUE) === FALSE) {
            $this->form_validation->set_message('xss_clean', 'The %s is invalid charactor');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_captcha($captcha) {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );


        // $APIkey = "6LdeNw4TAAAAAIwPw9ns6VWtf9y5Nod9QyUpLZdb";
        $APIkey = "6Le89SITAAAAAH56kHWGmu7SW5Hkfq8WRCEy81Q3";
        $postresult = $_POST['g-recaptcha-response'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$APIkey&response=$postresult", false, stream_context_create($arrContextOptions));



        if (strpos($response, 'true')) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_captcha', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry !</strong> Your {field} is not verified. </div>');
            return FALSE;
        }
    }

}
