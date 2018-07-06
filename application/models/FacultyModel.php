<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FacultyModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function record_count_all_faculty() {
        return $this->db->count_all_results('faculty');
    }
    
    public function get_all_faculty_info($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('faculty');
        return $query->result();
    }
    
    public function get_list_of_faculty()
    {
         $query = $this->db->get('faculty');
        return $query->result();
    }

        public function add_new_faculty($facultyName)
    {
        $data = array('name' => $facultyName);
         $this->db->insert('faculty', $data);
    }
    
    public function get_faculty_info_by_faculty_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('faculty');
        return $query->result();
    }
    
    public function update_faculty($id, $facultyName)
    {
        $data = array('name' => $facultyName);
        $this->db->where('id', $id);
        $this->db->update('faculty', $data);
    }
    
    public function check_if_any_program_is_in_faculty($id)
    {
        $this->db->where('facultyId', $id);
        $query = $this->db->get('program');
        return $query->result();
    }
    
    public function delete_faculty($id)
    {
        $query = $this->db->get_where('faculty', array('id' => $id));
        if ($query->num_rows() > 0) {
            $this->db->delete('faculty', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
}