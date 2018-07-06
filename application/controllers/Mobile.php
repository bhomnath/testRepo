<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('file');
        $this->load->model('mobileModel');
        $this->load->helper('url');

        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        redirect('mobile/getData', 'refresh');
    }

    public function getData() {
        $faculties = $this->mobileModel->get_faculty();
        $faculty = array();
        foreach ($faculties as $data1) {
            array_push($faculty, (object) $data1);
        }
        $programs = $this->mobileModel->get_program();
        $program = array();
        foreach ($programs as $data2) {
            array_push($program, (object) $data2);
        }
        $subjects = $this->mobileModel->get_subject();
        $subject = array();
        foreach ($subjects as $data3) {
            array_push($subject, (object) $data3);
        }

        $allInfo = array('Faculty' => $faculty, 'Program' => $program, 'Subject' => $subject);
        echo json_encode($allInfo);
    }

    public function getSyllabus($id) {

        if (!empty($id)) {
            $subjects = $this->mobileModel->get_subject_by_program_id($id);
           if (!empty($subjects)) {
                $info = array();
                $textBookInfo = array();
                $referenceBookInfo = array();
                $objectivesInfo = array();
                $laboratoryInfo = array();
                 $counterSyllabusTitle = 0;
                 $referenceId=1;
                foreach ($subjects as $subj) {
                    $subId = $subj->subjectId;
                    $subName = $subj->name;
                    $subjectText = $subj->syllabusText;                    
                    $syllabusContent = $this->readFile($subjectText);
                    $objectives = trim(strip_tags($this->getObjectives($syllabusContent)));
                    $textBook = trim(strip_tags($this->getTextBook($syllabusContent)));
                    $referenceBook = trim(strip_tags($this->getReferenceBook($syllabusContent)));
                    $laboratory = trim(strip_tags($this->getLaboratory($syllabusContent)));
                    $titleCount = trim(strip_tags($this->gettitleCount($syllabusContent)));
                    settype($titleCount, "integer");

                    for ($i = 1; $i <= $titleCount; $i++) {
                        $TitleNo = trim(strip_tags($this->getTitleNo($syllabusContent, $i)));
                        $title = trim(strip_tags($this->gettitle($syllabusContent, $i)));
                        $content = trim(strip_tags($this->getContent($syllabusContent, $i)));
                        $creditHr = trim(strip_tags($this->getCreditHour($syllabusContent, $i)));
                        $info1 = array('id' => $i + $counterSyllabusTitle, 'subId' => $subId, 'titleNo' => $TitleNo, 'title' => $title, 'content' => $content, 'hours' => $creditHr);
                        array_push($info, $info1);
                    }
                    $info2 = array('id' => $referenceId, 'subId' => $subId, 'content' => $textBook);
                    array_push($textBookInfo, $info2);
                    $info3 = array('id' => $referenceId, 'subId' => $subId, 'content' => $referenceBook);
                    array_push($referenceBookInfo, $info3);
                    $info4 = array('id' => $referenceId, 'subId' => $subId, 'content' => $objectives);
                    array_push($objectivesInfo, $info4);
                    $info5 = array('id' => $referenceId, 'subId' => $subId, 'content' => $laboratory);
                    array_push($laboratoryInfo, $info5);
                    $allInfo = array('Syllabus' => $info, 'Objectives' => $objectivesInfo, 'Text Book' => $textBookInfo, 'Reference Book' => $referenceBookInfo, 'Laboratory' => $laboratoryInfo);
                    $counterSyllabusTitle = $counterSyllabusTitle + $titleCount;
                    $referenceId++;
                    
                    }
                
                echo json_encode($allInfo);
            }
        } else {
            
        }
    }
    
    
    public function updateSyllabus()
    {
        if(isset($_GET['program'])){
        $program = $_GET['program'];
        }else{
           $program = NULL; 
        }
        if(isset($_GET['date'])){
        $date = date('Y-m-d', strtotime($_GET['date']));
        }else{
           $date = NULL; 
        }        
        
          if (!empty($program)) {
            $subjects = $this->mobileModel->get_subject_by_program_id_and_date($program, $date);
         if (!empty($subjects)) {
                $info = array();
                $textBookInfo = array();
                $referenceBookInfo = array();
                $objectivesInfo = array();
                $laboratoryInfo = array();
                 $counterSyllabusTitle = 0;
                 $referenceId=1;
                foreach ($subjects as $subj) {
                    $subId = $subj->subjectId;
                    $subName = $subj->name;
                    $subjectText = $subj->syllabusText;                    
                    $syllabusContent = $this->readFile($subjectText);
                    $objectives = trim(strip_tags($this->getObjectives($syllabusContent)));
                    $textBook = trim(strip_tags($this->getTextBook($syllabusContent)));
                    $referenceBook = trim(strip_tags($this->getReferenceBook($syllabusContent)));
                    $laboratory = trim(strip_tags($this->getLaboratory($syllabusContent)));
                    $titleCount = trim(strip_tags($this->gettitleCount($syllabusContent)));
                    settype($titleCount, "integer");

                    for ($i = 1; $i <= $titleCount; $i++) {
                        $TitleNo = trim(strip_tags($this->getTitleNo($syllabusContent, $i)));
                        $title = trim(strip_tags($this->gettitle($syllabusContent, $i)));
                        $content = trim(strip_tags($this->getContent($syllabusContent, $i)));
                        $creditHr = trim(strip_tags($this->getCreditHour($syllabusContent, $i)));
                        $info1 = array('id' => $i + $counterSyllabusTitle, 'subId' => $subId, 'titleNo' => $TitleNo, 'title' => $title, 'content' => $content, 'hours' => $creditHr);
                        array_push($info, $info1);
                    }
                    $info2 = array('id' => $referenceId, 'subId' => $subId, 'content' => $textBook);
                    array_push($textBookInfo, $info2);
                    $info3 = array('id' => $referenceId, 'subId' => $subId, 'content' => $referenceBook);
                    array_push($referenceBookInfo, $info3);
                    $info4 = array('id' => $referenceId, 'subId' => $subId, 'content' => $objectives);
                    array_push($objectivesInfo, $info4);
                    $info5 = array('id' => $referenceId, 'subId' => $subId, 'content' => $laboratory);
                    array_push($laboratoryInfo, $info5);
                    $allInfo = array('Syllabus' => $info, 'Objectives' => $objectivesInfo, 'Text Book' => $textBookInfo, 'Reference Book' => $referenceBookInfo, 'Laboratory' => $laboratoryInfo);
                    $counterSyllabusTitle = $counterSyllabusTitle + $titleCount;
                    $referenceId++;
                    
                    }
                
                echo json_encode($allInfo);
            }
        } else {
            
        }
    }
    
    public function checkSubject()
    {
        if(isset($_GET['date'])){
        $date = date('Y-m-d', strtotime($_GET['date']));
        }else{
           $date = NULL; 
        }  
        
        
        $faculties = $this->mobileModel->get_faculty_for_new_changes($date);
        $faculty = array();
        foreach ($faculties as $data1) {
            array_push($faculty, (object) $data1);
        }
        $programs = $this->mobileModel->get_program_for_new_changes($date);
        $program = array();
        foreach ($programs as $data2) {
            array_push($program, (object) $data2);
        }
        $subjects = $this->mobileModel->get_subject_for_new_changes($date);
        $subject = array();
        foreach ($subjects as $data3) {
            array_push($subject, (object) $data3);
        }

        $allInfo = array('Faculty' => $faculty, 'Program' => $program, 'Subject' => $subject);
        echo json_encode($allInfo);
    }

    public function readFile($fileName) {
        if (file_exists(FCPATH . '/syllabus/' . $fileName)) {

            $handle = file_get_contents(FCPATH . '/syllabus/' . $fileName);

            return $handle;
        }
    }

    public function getObjectives($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'objectives')]");
        return $doc->saveHTML($node->item(0));
    }
    
    public function getTextBook($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'courseBook')]");
        return $doc->saveHTML($node->item(0));
    }
    
    public function getReferenceBook($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'referenceBook')]");
        return $doc->saveHTML($node->item(0));
    }
    
    public function getLaboratory($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'laboratory')]");
        return $doc->saveHTML($node->item(0));
    }

    public function gettitleCount($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'titleCount')]");
        return $doc->saveHTML($node->item(0));
    }

    public function getTitleNo($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $classes = 'titleNo' . $i;
//return $classes;
        $node = $finder->query("//*[contains(@class, '$classes')]");
        return $doc->saveHTML($node->item(0));
    }

    public function gettitle($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $class = 'title' . $i;
        $node = $finder->query("//*[contains(@class, '$class')]");
        return ($doc->saveHTML($node->item(0)));
    }

    public function getContent($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $class = 'content' . $i;
        $node = $finder->query("//*[contains(@class, '$class')]");
        return ($doc->saveHTML($node->item(0)));
    }

    public function getCreditHour($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $class = 'creditHours' . $i;
        $node = $finder->query("//*[contains(@class, '$class')]");
        return ($doc->saveHTML($node->item(0)));
    }

}


//from here the server code executes
/*
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('file');
        $this->load->model('mobileModel');
        $this->load->helper('url');

        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        redirect('mobile/getData', 'refresh');
    }

    public function getData() {
        $faculties = $this->mobileModel->get_faculty();
        $faculty = array();
        foreach ($faculties as $data1) {
            array_push($faculty, (object) $data1);
        }
        $programs = $this->mobileModel->get_program();
        $program = array();
        foreach ($programs as $data2) {
            array_push($program, (object) $data2);
        }
        $subjects = $this->mobileModel->get_subject();
        $subject = array();
        foreach ($subjects as $data3) {
            array_push($subject, (object) $data3);
        }

        $allInfo = array('Faculty' => $faculty, 'Program' => $program, 'Subject' => $subject);
        echo json_encode($allInfo);
    }

    public function getSyllabus($id) {

        if (!empty($id)) {
            $subjects = $this->mobileModel->get_subject_by_program_id($id);
            
            if (!empty($subjects)) {
                $info = array();
                $textBookInfo = array();
                $referenceBookInfo = array();
                $objectivesInfo = array();
                $laboratoryInfo = array();
                 $counterSyllabusTitle = 0;
                 $referenceId=1;
                foreach ($subjects as $subj) {
                    $subId = $subj->subjectId;
                    $subName = $subj->name;
                    $subjectText = $subj->syllabusText;                    
                    $syllabusContent = $this->readFile($subjectText);
                    $objectives = trim(strip_tags($this->getObjectives($syllabusContent)));
                    $textBook = trim(strip_tags($this->getTextBook($syllabusContent)));
                    $referenceBook = trim(strip_tags($this->getReferenceBook($syllabusContent)));
                    $laboratory = trim(strip_tags($this->getLaboratory($syllabusContent)));
                    $titleCount = trim(strip_tags($this->gettitleCount($syllabusContent)));
                    settype($titleCount, "integer");

                    for ($i = 1; $i <= $titleCount; $i++) {
                        $TitleNo = trim(strip_tags($this->getTitleNo($syllabusContent, $i)));
                        $title = trim(strip_tags($this->gettitle($syllabusContent, $i)));
                        $content = trim(strip_tags($this->getContent($syllabusContent, $i)));
                        $creditHr = trim(strip_tags($this->getCreditHour($syllabusContent, $i)));
                        $info1 = array('id' => $i + $counterSyllabusTitle, 'subId' => $subId, 'titleNo' => $TitleNo, 'title' => $title, 'content' => $content, 'hours' => $creditHr);
                        array_push($info, $info1);
                    }
                    $info2 = array('id' => $referenceId, 'subId' => $subId, 'content' => $textBook);
                    array_push($textBookInfo, $info2);
                    $info3 = array('id' => $referenceId, 'subId' => $subId, 'content' => $referenceBook);
                    array_push($referenceBookInfo, $info3);
                    $info4 = array('id' => $referenceId, 'subId' => $subId, 'content' => $objectives);
                    array_push($objectivesInfo, $info4);
                    $info5 = array('id' => $referenceId, 'subId' => $subId, 'content' => $laboratory);
                    array_push($laboratoryInfo, $info5);
                    $allInfo = array('Syllabus' => $info, 'Objectives' => $objectivesInfo, 'Text Book' => $textBookInfo, 'Reference Book' => $referenceBookInfo, 'Laboratory' => $laboratoryInfo);
                    $counterSyllabusTitle = $counterSyllabusTitle + $titleCount;
                    $referenceId++;
                    
                    }
                
                echo json_encode($allInfo);
            }
        } else {
            
        }
    }

    public function readFile($fileName) {
        if (file_exists(FCPATH . '/syllabus/' . $fileName)) {

            $handle = file_get_contents(FCPATH . '/syllabus/' . $fileName);

            return $handle;
        }
    }

    public function getObjectives($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'objectives')]");
        return $doc->saveHTML($node->item(0));
    }
    
    public function getTextBook($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'courseBook')]");
        return $doc->saveHTML($node->item(0));
    }
    
    public function getReferenceBook($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'referenceBook')]");
        return $doc->saveHTML($node->item(0));
    }
    
    public function getLaboratory($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'laboratory')]");
        return $doc->saveHTML($node->item(0));
    }

    public function gettitleCount($syllabusContent) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $node = $finder->query("//*[contains(@class, 'titleCount')]");
        return $doc->saveHTML($node->item(0));
    }

    public function getTitleNo($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $classes = 'titleNo' . $i;
//return $classes;
        $node = $finder->query("//*[contains(@class, '$classes')]");
        return $doc->saveHTML($node->item(0));
    }

    public function gettitle($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $class = 'title' . $i;
        $node = $finder->query("//*[contains(@class, '$class')]");
        return ($doc->saveHTML($node->item(0)));
    }

    public function getContent($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $class = 'content' . $i;
        $node = $finder->query("//*[contains(@class, '$class')]");
        return ($doc->saveHTML($node->item(0)));
    }

    public function getCreditHour($syllabusContent, $i) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($syllabusContent);
        $finder = new DomXPath($doc);
        $class = 'creditHours' . $i;
        $node = $finder->query("//*[contains(@class, '$class')]");
        return ($doc->saveHTML($node->item(0)));
    }

}
 * 
 * 
 */
