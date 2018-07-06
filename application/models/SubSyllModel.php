<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SubSyllModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function get_all_faculty()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('faculty');
        return $query->result();
    }
    
    public function get_all_program_by_faculty_id($id)
    {
        $this->db->where('facultyId', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('program');
        return $query->result();
    }

    public function record_count_all_subject($id) {
        $this->db->where('programId', $id);
        return $this->db->count_all_results('subject');
    }
    
    public function get_all_subject_info($limit, $start, $id) {
        $this->db->limit($limit, $start);
        $this->db->where('programId', $id);
        $this->db->order_by('subject.id', 'DESC');
        $this->db->select('subject.*,syllabus.*, subject.id as subId');
        $this->db->from('subject');
        $this->db->join('syllabus', 'subject.id = syllabus.subjectId', 'inner'); 
        $query = $this->db->get();
        return $query->result();
    }
    
    public function add_new_subject_and_syllabus($facultyName, $programName, $subjectCode, $subjectName, $semester, $credit, $fileName)
    {
        $this->db->trans_start();
        $data = array(
            'name' => $subjectName,
            'semester' => $semester,
            'code' => $subjectCode,
            'credit' => $credit,
            'programId' => $programName);
         $this->db->insert('subject', $data);
         $insert_id = $this->db->insert_id();
         
         $data1 = array(
             'subjectId' => $insert_id,
             'syllabusText' => $fileName);
         $this->db->insert('syllabus', $data1);
         
         $this->db->trans_complete();   
        return $insert_id;
    }
    
    public function add_new_subject_and_syllabus_for_notification($facultyName, $programName, $subjectId, $curDate, $flag)
    {
        $data = array(
            'faculty_id' => $facultyName,
            'program_id' => $programName,
            'subject_id' => $subjectId,
            'date' => $curDate,
            'flag' => $flag);
         $this->db->insert('subject_inup_temp', $data);
    }

        public function get_subSyllabus_info_by_subSyllabus_id($id)
    {
        $this->db->order_by('subject.id', 'DESC');
        $this->db->where('subject.id', $id);
        $this->db->select('subject.*,syllabus.*, subject.id as subId');
        $this->db->from('subject');
        $this->db->join('syllabus', 'subject.id = syllabus.subjectId', 'inner'); 
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_program_info_by_program_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('program');
        return $query->result();
    }
    
    public function get_faculty_id_associated_to_program_by_program_id($programId)
    {
        $this->db->select('facultyId');
        $this->db->where('id', $programId);
        $query = $this->db->get('program')->result();
        if(!empty($query)){
        return $query[0]->facultyId;
        }else{
            return NULL;
        }
    }
    
    public function update_subject_and_syllabus_with_out_file($subjectId, $facultyName, $programName, $subjectCode, $subjectName, $semester, $credit)
    {
        $data = array(
            'name' => $subjectName,
            'semester' => $semester,
            'code' => $subjectCode,
            'credit' => $credit,
            'programId' => $programName);
        $this->db->where('id', $subjectId);
         $this->db->update('subject', $data);
    }
    
    public function update_subject_and_syllabus_with_file($subjectId, $facultyName, $programName, $subjectCode, $subjectName, $semester, $credit, $fileName)
    {
        $data = array(
            'name' => $subjectName,
            'semester' => $semester,
            'code' => $subjectCode,
            'credit' => $credit,
            'programId' => $programName);
        $this->db->where('id', $subjectId);
         $this->db->update('subject', $data);
         
         $data1 = array(
             'syllabusText' => $fileName
         );
         $this->db->where('subjectId', $subjectId);
         $this->db->update('syllabus', $data1);
    }
    
    public function delete_subject_and_syllabus($subjectId)
    {
         $this->db->trans_start();
        
         $this->db->where('subjectId', $subjectId);
        $this->db->delete('syllabus');
        
        $this->db->where('id', $subjectId);
        $this->db->delete('subject');
        
        $this->db->trans_complete();   
        if ($this->db->trans_status() === FALSE) {
    # Something went wrong.
    $this->db->trans_rollback();
    return FALSE;
} 
else {
    # Everything is Perfect. 
    # Committing data to the database.
    $this->db->trans_commit();
    return TRUE;
}
    }
}