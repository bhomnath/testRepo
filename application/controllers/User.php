<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('userModel');
        $this->load->model('dbmodel');
        $this->load->model('mobileModel');
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
                //$loginDatetime = $userDet->last_login_date;
            }
            $data['colorantFlag'] = $this->dbmodel->get_colorant_price_update_flag();
            $data['baseKgFlag'] = $this->dbmodel->get_base_in_kg_price_update_flag();
            $data['baseLtrFlag'] = $this->dbmodel->get_base_in_ltr_price_update_flag();

            $config = array();
            $config["base_url"] = base_url() . "user/index";
            $config["total_rows"] = $this->userModel->record_count_all_admin_users();
            $config["per_page"] = 25;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["num_links"] = $config["total_rows"] / $config["per_page"];
            $data['users'] = $this->userModel->get_all_admin_user($config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();

            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/users/listAll', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function addNew() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                // $loginDatetime = $userDet->last_login_date;
            }

            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/users/addNew');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function addNewUser() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                //$loginDatetime = $userDet->last_login_date;
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|regex_match[/^[a-z,A-Z\ ]{2,35}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|regex_match[/^[a-z,A-Z\ ]{2,35}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('email', 'User Email Id', 'trim|regex_match[/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/]|required|callback_xss_clean');

            $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_xss_clean');
            $this->form_validation->set_rules('rePassword', 'Re-Password', 'trim|matches[password]|required|callback_xss_clean');

            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->addNew();
            } else {

                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $email = $this->input->post('email');

                $password = $this->input->post('password');
                $userType = 'administrator';
                $userEmail = $this->userModel->check_user($email, $userType);
                if (!empty($userEmail)) {


                    $data['validation_message'] = '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Sorry! User Email ID already exsists.</div>';
                    $this->load->view('dashboard/templates/header');
                    $this->load->view('dashboard/templates/sideNavigation');
                    $this->load->view('dashboard/users/addNew');
                    $this->load->view('dashboard/templates/footer');
                } else {
                    $this->userModel->add_new_user($firstname, $lastname, $email, $password, $userType);
                    $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>User added successfully.</div>');
                    return redirect('user/index', 'refresh');
                }
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function editUser($id = NULL) {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                // $loginDatetime = $userDet->last_login_date;
            }

            $data['userInfo'] = $this->userModel->get_user_info_by_id($id);
            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/users/editUser', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function updateUserInfo() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                //$loginDatetime = $userDet->last_login_date;
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|regex_match[/^[a-z,A-Z\ ]{2,35}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|regex_match[/^[a-z,A-Z\ ]{2,35}$/]|required|callback_xss_clean');
            $this->form_validation->set_rules('email', 'User Email Id', 'trim|regex_match[/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/]|required|callback_xss_clean');

            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $this->editUser($id);
            } else {
                $id = $this->input->post('id');
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $email = $this->input->post('email');

                $userInfo = $this->userModel->get_user_info_by_id($id);
                if (!empty($userInfo)) {
                    foreach ($userInfo as $userData) {
                        $userType = $userData->user_type;
                        $oldEmail = $userData->user_email;
                    }
                } else {
                    $userType = NULL;
                }
                $check_user = $this->userModel->check_email_username_for_edit($email, $id, $userType);
                if ($check_user == true) {
                    $this->userModel->update_user_info($id, $firstname, $lastname, $email, $district, $vdcMunic, $wardNo, $toleName, $houseNumber, $contactnum);
                    $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>User data updated successfully.</div>');
                    if ($useremail == $oldEmail) {
                        $data = array(
                            'email' => $email);
                        $this->session->set_userdata($data);
                    }

                    if ($userType == '2') {
                        redirect('user/index', 'refresh');
                    } else {
                        redirect('user/mobileUsers', 'refresh');
                    }
                } elseif ($check_user == false) {
                    $this->session->set_flashdata('message', 'Username or Email already exist');
                    $data['userInfo'] = $this->userModel->get_user_info_by_id($id);
                    $this->load->view('dashboard/templates/header');
                    $this->load->view('dashboard/templates/sideNavigation');
                    $this->load->view('dashboard/users/editUser', $data);
                    $this->load->view('dashboard/templates/footer');
                } else {
                    $this->session->set_flashdata('message', 'Error. Please Try again later.');
                    $data['userInfo'] = $this->userModel->get_user_info_by_id($id);
                    $this->load->view('dashboard/templates/header');
                    $this->load->view('dashboard/templates/sideNavigation');
                    $this->load->view('dashboard/users/editUser', $data);
                    $this->load->view('dashboard/templates/footer');
                }
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function deleteUser($id = NULL) {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userInfo = $this->userModel->get_user_info_by_id($id);
            if (!empty($userInfo)) {
                foreach ($userInfo as $userData) {
                    $userType = $userData->user_type;
                    $userEmailAdd = $userData->user_email;
                }
            } else {
                $userType = NULL;
            }
            if ($userEmailAdd == $useremail && $userType == '2') {
                $this->session->set_flashdata("message", '<div class="alert alert-warning" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry ! </strong><br/>You are curently logged in and you can not delete yourself.</div>');
                redirect('user/index', 'refresh');
            } else {
                $this->dbuser->delete_user_by_id($id);
                $this->session->set_flashdata("message", '<div class="alert alert-success" style="margin-bottom: 10;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success ! </strong><br/>User deleted successfully.</div>');

                if ($userType == '2') {
                    redirect('user/index', 'refresh');
                } else {
                    redirect('user/mobileUsers', 'refresh');
                }
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function profile() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                // $loginDatetime = $userDet->last_login_date;
            }

            $id = $this->session->userdata('user_id');
            $data['userInfo'] = $this->userModel->get_user_info_by_id($id);
            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/users/profile', $data);
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function changePass() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                //$loginDatetime = $userDet->last_login_date;
            }


            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/users/changePass');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function email() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('emailId', 'User Email Id', 'trim|regex_match[/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {

                $this->changePass();
            } else {
                $emailId = $this->input->post('emailId');
                $query = $this->userModel->get_user_info_by_email_id($emailId);
                if (!empty($query)) {
                    foreach ($query as $uData) {
                        $toEmail = $uData->user_email;
                        $fullName = $uData->first_name . ' ' . $uData->last_name;
                        $userType = $uData->user_type;
                    }
                    $token = $this->getRandomString(10);
                    $this->userModel->update_emailed_user($toEmail, $token);
                    $this->sendEmail($toEmail, $fullName, $token);
                    $this->session->set_flashdata('message', 'Email with password reset link has been sent, please check inbox.');
                    if ($userType == '2') {
                        redirect('user/index', 'refresh');
                    } else {
                        redirect('user/mobileUsers', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('message', 'Email ID does not exist');
                    redirect($url, 'refresh');
                }
            }
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function sendEmail($toEmail = NULL, $fullName = NULL, $token = NULL) {
        $this->load->helper('emailsend_helper');
        $subject = "Password Reset";
        $imglink = base_url() . "content/bnw/images/bnw.png";
        $link = base_url();
        $message = password_reset_email($toEmail, $fullName, $token, $link, $imglink);
        send_password_reset_email($toEmail, $subject, $message);
    }

    public function resetPassword() {
        
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

    public function changePassword() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                // $loginDatetime = $userDet->last_login_date;
            }


            $this->load->view('dashboard/templates/header');
            $this->load->view('dashboard/templates/sideNavigation');
            $this->load->view('dashboard/users/updatePassword');
            $this->load->view('dashboard/templates/footer');
        } else {
            redirect('login/index/?url=' . $url, 'refresh');
        }
    }

    public function updatePassword() {
        $url = current_url();
        if ($this->session->userdata('logged_in') == true) {
            $useremail = $this->session->userdata('email');
            $userDetails = $this->userModel->get_user_info_by_email_id($useremail);
            foreach ($userDetails as $userDet) {
                // $loginDatetime = $userDet->last_login_date;
            }


            $this->load->library('form_validation');
            $this->form_validation->set_rules('oldPassword', 'Current Password', 'trim|required|callback_xss_clean');
            $this->form_validation->set_rules('password', 'New Password', 'trim|required|callback_xss_clean');
            $this->form_validation->set_rules('rePassword', 'Confirm New Password', 'trim|matches[password]|required|callback_xss_clean');
            $this->form_validation->set_error_delimiters('<div class="form_errors">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $this->changePassword();
            } else {

                $oldPassword = $this->input->post('oldPassword');
                $okay = $this->userModel->check_user_email_and_pass_matches($useremail, $oldPassword);
                if (!empty($okay)) {
                    $newPassword = $this->input->post('password');
                    $this->userModel->update_user_password_from_dashboard($useremail, $newPassword);
                    $this->session->set_flashdata('message', 'Password has been updated successfully.');
                    redirect('user/index', 'refresh');
                } else {
                    $data['error'] = "Sorry, Current password for your ID did not match.";
                    $this->load->view('dashboard/templates/header');
                    $this->load->view('dashboard/templates/sideNavigation');
                    $this->load->view('dashboard/users/updatePassword', $data);
                    $this->load->view('dashboard/templates/footer');
                }
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
