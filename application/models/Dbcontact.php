<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dbcontact extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function add_contact_forms_data($date, $fname, $lname, $email, $organization, $phone, $subject, $message) {
        $data = Array(
            'message_date_time' => $date,
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => $email,
            'organization' => $organization,
            'phone_no' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => '1');
        $this->db->insert('contact_info', $data);
        
        
    }
    
    
    
    }

