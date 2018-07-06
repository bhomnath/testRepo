<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProgramModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function record_count_all_program() {
        return $this->db->count_all_results('program');
    }
    
    public function get_all_program_info($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('program');
        return $query->result();
    }
    
    public function add_new_program($facultyName, $programNameShort, $programNameFull)
    {
        $data = array(
            'name' => $programNameShort,
            'fullName' => $programNameFull,
            'facultyId' => $facultyName);
         $this->db->insert('program', $data);
    }
    
    public function get_list_of_program_by_faculty_id($id)
    {
        $this->db->where('facultyId', $id);
        $query = $this->db->get('program');
        return $query->result();
    }
    
    public function get_program_info_by_program_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('program');
        return $query->result();
    }
    
    public function update_program($id, $facultyName, $programNameShort, $programNameFull)
    {
        $data = array(
            'name' => $programNameShort,
            'fullName' => $programNameFull,
            'facultyId' => $facultyName);
         $this->db->where('id', $id);
         $this->db->update('program', $data);
    }
    
    public function check_if_any_subject_is_in_program($id)
    {
        $this->db->where('programId', $id);
        $query = $this->db->get('subject');
        return $query->result();
    }
    
    public function delete_program($id)
    {
        $query = $this->db->get_where('program', array('id' => $id));
        if ($query->num_rows() > 0) {
            $this->db->delete('program', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}