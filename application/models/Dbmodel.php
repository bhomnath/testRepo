<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dbmodel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
   
 public function get_syllabus_insert_flag()
{
    $this->db->where('flag', '1');
    $query = $this->db->get('subject_inup_temp');
    if(!empty($query)){
           return $query->num_rows();
               }else{
                   return NULL;
               }
    
}


public function get_syllabus_update_flag(){
    $this->db->where('flag', '2');
    $query = $this->db->get('subject_inup_temp');
    if(!empty($query)){
           return $query->num_rows();
               }else{
                   return NULL;
               }
    
}

public function update_syllabus_insert_info_to_database()
    {
       //  $this->db->trans_start();
    $this->db->where('flag', '1');
         $query = $this->db->get('subject_inup_temp');
foreach ($query->result() as $row) {
      $facId = $row->faculty_id;
      $prgId = $row->program_id;
      $subjectId = $row->subject_id;
      $date = $row->date;
      
      $data = array(
            'faculty_id' => $facId,
            'program_id' => $prgId,
            'subject_id' => $subjectId,
            'updated_at' => $date,
            'created_at' => $date);
         $this->db->insert('subject_update_info', $data);
}  
    $this->db->delete('subject_inup_temp',array("flag"=>'1'));   
                $this->db->trans_complete();   
                
    }
    
    public function get_program_id_for_syllabus_insert_info_to_database()
    {
        $this->db->select('program.*,subject_inup_temp.program_id');
        $this->db->where('flag', '1');
        $this->db->from('subject_inup_temp');
        $this->db->group_by('subject_inup_temp.program_id'); 
        $this->db->join('program', 'subject_inup_temp.program_id = program.id', 'inner'); 
        $query = $this->db->get('');
        return $query->result();
        
    }
    
    public function get_program_id_for_syllabus_update_info_to_database()
    {
        $this->db->select('program.*,subject_inup_temp.program_id');
        $this->db->where('flag', '2');
        $this->db->from('subject_inup_temp');
        $this->db->group_by('subject_inup_temp.program_id'); 
        $this->db->join('program', 'subject_inup_temp.program_id = program.id', 'inner'); 
        $query = $this->db->get('');
        return $query->result();
    }

    public function update_syllabus_update_info_to_database()
    {
       //  $this->db->trans_start();
    $this->db->where('flag', '2');
         $query = $this->db->get('subject_inup_temp');
foreach ($query->result() as $row) {
      $facId = $row->faculty_id;
      $prgId = $row->program_id;
      $subjectId = $row->subject_id;
      $date = $row->date;
      
      $data = array(
            'faculty_id' => $facId,
            'program_id' => $prgId,
            'subject_id' => $subjectId,
            'updated_at' => $date,
            'created_at' => $date);
         $this->db->insert('subject_update_info', $data);
}  
    $this->db->delete('subject_inup_temp',array("flag"=>'2'));   
                $this->db->trans_complete();   
                
    }







    
}