<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('userModel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index() {
        if (isset($_GET['url'])) {
            $data['link'] = $_GET['url'];
        } else {

            $data['link'] = base_url() . 'dashboard';
        }
        if ($this->session->userdata('logged_in') == TRUE) {

            redirect('dashboard');
        } else {

            $this->load->view('dashboard/login/login', $data);
        }
    }

    public function validate() {
        $link = $this->input->post('requersUrl');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userEmail', 'Email ID', 'trim|regex_match[/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/]|required|callback_xss_clean');
        $this->form_validation->set_rules('userPass', 'Password', 'trim|required|callback_xss_clean');

        $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {

            $query = $this->userModel->validate();
            if ($query) {
                date_default_timezone_set("Asia/Kathmandu");
                $loginDate = date("Y-m-d h:i:s");
                // $this->userModel->update_login_date_time($loginDate, $query);
                if ($link == base_url() . '/login/logout') {
                    redirect('dashboard/index', 'refresh');
                } else {
                    redirect($link);
                }
            } else { // incorrect username or password
                $this->session->set_flashdata("flashMessage", '<div class="alert alert-danger" style="margin-bottom: 0;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Username or password is incorrect. Please review and login with correct username and password.</div>');

                redirect('login/index/?url=' . $link, 'refresh');
            }
        }
    }

    function logout() {
        if ($this->session->userdata('logged_in') == TRUE) {
            $user_email = $this->session->userdata('email');
            $data = array(
                'email' => $user_email,
                'logged_in' => true
            );
            $this->session->unset_userdata($data);
            $this->session->sess_destroy();
            redirect('login');
        } else {
            $this->session->sess_destroy();
            redirect('login');
        }
    }

    public function email() {
        $url = current_url();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('emailId', 'User Email Id', 'trim|regex_match[/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/]|required|callback_xss_clean');
        $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $emailId = $this->input->post('emailId');
            $query = $this->dbuser->get_user_info_by_email_id($emailId);
            if (!empty($query)) {
                foreach ($query as $uData) {
                    $userType = $uData->user_type;
                    $toEmail = $uData->user_email;
                    $fullName = $uData->first_name . ' ' . $uData->last_name;
                }
                $token = $this->getRandomString(10);
                $this->dbuser->update_emailed_user($toEmail, $token);
                $this->sendEmail($toEmail, $fullName, $token);
                $this->session->set_flashdata('message', 'Email with password reset link has been sent, please check inbox.');

                redirect('login/index', 'refresh');
            } else {

                $this->session->set_flashdata('flashMessage', 'Email ID does not exist');
                redirect($url, 'refresh');
            }
        }
    }

    function getRandomString($length) {
        $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
        $validCharNumber = strlen($validCharacters);
        $result = "";

        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
        return $result;
    }

    public function sendEmail($toEmail = NULL, $fullName = NULL, $token = NULL) {
        $this->load->helper('emailsend_helper');
        $subject = "Password Reset";
        $imglink = base_url() . "content/images/bnw.png";
        $link = base_url();
        $message = password_reset_email($toEmail, $fullName, $token, $link, $imglink);
        send_password_reset_email($toEmail, $subject, $message);
    }

    public function resetPassword() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        } else {
            $token = NULL;
        }
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
        } else {
            $email = NULL;
        }

        $data['query'] = $this->dbuser->get_user_password_reset_token_status($token, $email);

        if (!empty($data['query'])) {
            $this->load->view('dashboard/login/rePassword', $data);
        } else {
            $this->load->view('dashboard/login/tokenExpired', $data);
        }
    }

    public function setpassword() {

        if (isset($_POST['token'])) {
            $token = $_POST['token'];
        } else {
            $token = NULL;
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $email = NULL;
        }

        $data['tokene'] = $token;
        $data['query'] = $this->dbuser->get_user_password_reset_token_status($token, $email);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_xss_clean|max_length[200]|matches[password_confirmation]');
        $this->form_validation->set_rules('password_confirmation', 'Confirm password', 'required|callback_xss_clean|max_length[200]');
        $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
        if ($this->form_validation->run() == FALSE) {

            if (!empty($data['query'])) {
                $this->load->view('dashboard/login/rePassword', $data);
            } else {
                $this->load->view('dashboard/login/tokenExpired', $data);
            }
        } else {
            $userPassword = $this->input->post('password');
            $this->dbuser->update_user_password($email, $userPassword);
            $this->session->set_flashdata('flashMessage', 'Your password has been reseted. Please login with new password.');
            redirect('login', 'refresh');
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
