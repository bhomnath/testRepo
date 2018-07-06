<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mobileModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function queryWithProperTypes($query) {

  $fields = $query->field_data();
  $result = $query->result_array();

  foreach ($result as $r => $row) {
    $c = 0;
    foreach ($row as $header => $value) {

      // fix variables types according to what is expected from
      // the database, as CodeIgniter get all as string.

      // $c = column index (starting from 0)
      // $r = row index (starting from 0)
      // $header = column name
      // $result[$r][$header] = that's the value to fix. Must
      //                        reference like this because settype
      //                        uses a pointer as param

      $field = $fields[$c];

      switch ($field->type) {

        case MYSQLI_TYPE_LONGLONG: // 8 = bigint
        case MYSQLI_TYPE_LONG: // 3 = int
        case MYSQLI_TYPE_TINY: // 1 = tinyint
        case MYSQLI_TYPE_SHORT: // 2 = smallint
        case MYSQLI_TYPE_INT24: // 9 = mediumint
        case MYSQLI_TYPE_YEAR: // 13 = year
          settype($result[$r][$header], 'integer');
          break;

        case MYSQLI_TYPE_DECIMAL: // 0 = decimal
        case MYSQLI_TYPE_NEWDECIMAL: // 246 = decimal
        case MYSQLI_TYPE_FLOAT: // 4 = float
        case MYSQLI_TYPE_DOUBLE: // 5 = double
          settype($result[$r][$header], 'float');
          break;

        case MYSQLI_TYPE_BIT: // 16 = bit
          settype($result[$r][$header], 'boolean');
          break;

      }

      $c = $c + 1;
    }
  }

  return $result;
}
    
    public function get_faculty()
    {
        $query = $this->db->get('faculty');
        return $query->result();
    }
    
    public function get_faculty_for_new_changes($date)
    {
        $this->db->select('faculty.*');
        $this->db->from('faculty');
        $this->db->group_by('faculty.id');
        $this->db->where('subject_update_info.created_at>=', $date. '00:00:00');
        $this->db->join('subject_update_info', 'faculty.id = subject_update_info.faculty_id', 'inner'); 
        $query = $this->db->get('');
        return $query->result();  
    }

        public function get_program()
    {
        $this->db->select('program.*, MAX(subject_update_info.updated_at) as updated_at');
        $this->db->from('program');
        $this->db->group_by('program.id');
        $this->db->join('subject_update_info', 'program.id = subject_update_info.program_id', 'inner'); 
        $query = $this->db->get('');
        return $query->result();  
    }
    
    public function get_program_for_new_changes($date)
    {
        $this->db->select('program.*, MAX(subject_update_info.updated_at) as updated_at');
        $this->db->from('program');
        $this->db->group_by('program.id');
        $this->db->where('subject_update_info.created_at>=', $date. '00:00:00');
        $this->db->join('subject_update_info', 'program.id = subject_update_info.program_id', 'inner'); 
        $query = $this->db->get('');
        return $query->result(); 
    }

        public function get_subject()
    {
        $this->db->select('subject.*,syllabus.syllabusSections');
        $this->db->from('subject');
        $this->db->join('syllabus', 'subject.id = syllabus.subjectId', 'inner'); 
        $query = $this->db->get('');
        return $query->result();  
    }
    
    public function get_subject_for_new_changes($date)
    {
        $this->db->select('subject.*,syllabus.syllabusSections');
        $this->db->from('subject');
        $this->db->where('subject_update_info.created_at>=', $date. '00:00:00');
        $this->db->join('syllabus', 'subject.id = syllabus.subjectId', 'inner'); 
        $this->db->join('subject_update_info', 'subject.id = subject_update_info.subject_id', 'inner'); 
        $query = $this->db->get('');
        return $query->result(); 
    }

        public function get_subject_by_program_id($id)
    {
        $this->db->select('subject.*,syllabus.*');
        $this->db->where('programId', $id);
        $this->db->from('subject');
        $this->db->join('syllabus', 'subject.id = syllabus.subjectId', 'inner'); 
        $query = $this->db->get('');
        return $query->result();
    }    
    
    
    public function get_subject_by_program_id_and_date($program, $date)
    {
        $this->db->select('subject.*,syllabus.*');
        $this->db->where('programId', $program);
        $this->db->where('subject_update_info.created_at>=', $date. '00:00:00');
        $this->db->group_by('subject_update_info.subject_id');
        $this->db->from('subject_update_info');
        $this->db->join('syllabus', 'subject_update_info.subject_id = syllabus.subjectId', 'inner');
        $this->db->join('subject', 'subject_update_info.subject_id = subject.id', 'inner');
        $query = $this->db->get('');
        return $query->result();
    }
    
    

    
}