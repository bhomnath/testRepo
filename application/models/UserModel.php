<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class userModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function validate() {
        $this->db->where('user_email', $this->input->post('userEmail'));
        $this->db->where('user_pass', md5($this->input->post('userPass')));
        $this->db->where('user_status', '1');
        $this->db->where('user_type', 'administrator');
        $query = $this->db->get('user_info');
        if ($query->num_rows() == 1) {
            $user_id = $query->row()->id;
            $user_email = $query->row()->user_email;
            $data = array(
                'email' => $user_email,
                'user_id' => $user_id,
                'logged_in' => true
            );
            $this->session->set_userdata($data);
            return $user_id;
        } else {
            return FALSE;
        }
    }
    
    public function update_login_date_time($loginDate, $id)
    {
        $data = Array('last_login_date' => $loginDate);
        $this->db->where('id', $id);
        $this->db->where('user_status', '1');
        $this->db->where('user_type', '2');
        $this->db->update('user_info', $data);
    }
    
     public function get_user_info_by_id($id) {
        $this->db->where('user_status', '1');
        $this->db->where('id', $id);
        $query = $this->db->get("user_info");
        return $query->result();
    }
    
     public function update_emailed_user($to, $token) {
        $data = array(
            'user_token' => $token);
        $this->db->where('user_email', $to);
        $this->db->update('user_info', $data);
    }

    
    public function check_user_email_and_pass_matches($useremail, $oldPassword)
    {
        $this->db->where('user_email', $useremail);
        $this->db->where('user_pass', md5($oldPassword));
        $this->db->where('user_status', '1');
        $this->db->where('user_type', '2');
        $query = $this->db->get('user_info');
        return $query->result();
    }
    
    public function update_user_password_from_dashboard($useremail, $newPassword)
    {
        $data = Array('user_pass' => md5($newPassword));
        $this->db->where('user_email', $useremail);
        $this->db->where('user_status', '1');
        $this->db->where('user_type', '2');
        $this->db->update('user_info', $data);
    }
    
    public function update_user_info($id, $firstname, $lastname, $email, $district, $vdcMunic, $wardNo, $toleName, $houseNumber, $contactnum) {
        $data = Array(
            'first_name' => $firstname,
            'last_name' => $lastname,
            'user_email' => $email);
        $this->db->where('id', $id);
        $this->db->update('user_info', $data);
    }
    
    public function check_email_username_for_edit($email, $id, $userType) {
        $where1 = "`id` != $id and `user_type` = '$userType' and `user_email` = '$email' ";
        $this->db->where($where1);
        $query = $this->db->get("user_info");
        $count = $query->num_rows();
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function record_count_all_admin_users() {
        $this->db->where('user_status', '1');
        $this->db->where('user_type', 'administrator');
        return $this->db->count_all_results('user_info');
    }
    
    public function get_all_admin_user($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'DESC');
        $this->db->where('user_type', 'administrator');
        $this->db->where('user_status', '1');
        $query = $this->db->get('user_info');
        return $query->result();
    }
    
    public function check_user($email, $type) {
        $this->db->where('user_email', $email);
        $this->db->where('user_type', $type);
        $this->db->where('user_status', '1');
        $query = $this->db->get('user_info');
        return $query->result();
    }
    
    public function add_new_user($firstname, $lastname, $email, $password, $userType){
        $data = Array(
            'first_name' => $firstname,
            'last_name' => $lastname,
            'user_email' => $email,
            'user_type' => $userType,
            'user_pass' => md5($password),
            'user_status' => '1');
        $this->db->insert('user_info', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

/*here */
    
        public function validate_mobile_user($email)
    {
        $this->db->where('user_email', $email);      
        $this->db->where('user_status', '1');
        $this->db->where('user_type', '1');
        $query = $this->db->get('user_info');      
        return $query->result();
    }

    
    

    

   

    

    public function get_all_active_users() {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get("user_info");
        return $query->result();
    }
    
    public function delete_user_by_id($id)
    {
        $data = Array(
            'user_status' => '0');
        $this->db->where('id', $id);
        $this->db->update('user_info', $data);
    }

    public function get_user_role_by_user_name_and_id($username, $user_id) {
        $this->db->where('user_status', '1');
        $this->db->where('user_name', $username);
        $this->db->where('id', $user_id);
        $query = $this->db->get("user_info")->result();
        if (!empty($query)) {
            return $query[0]->user_type;
        } else {
            return NULL;
        }
    }
    
    public function get_user_info_by_email_id($useremail)
    {
        $this->db->where('user_status', '1');
         $this->db->where('user_type', '2');
        $this->db->where('user_email', $useremail);
        $query = $this->db->get("user_info");
        return $query->result();
    }
    
   

  
    
    
    
    
    
    public function get_user_password_reset_token_status($token, $email)
    {
         
        $this->db->where('user_token', $token );
          $this->db->where('user_email', $email );
        $query = $this->db->get('user_info');
        return $query->result();
    }
    
    public function update_user_password($email, $userPassword){
        $token = "";
        $data = array(
        'user_pass'=>md5($userPassword),
            'user_token'=>$token);
        $this->db->where('user_email', $email);
        $this->db->update('user_info', $data);
    }
    
    
    
    
    
    
    
    
    
    
    

}
