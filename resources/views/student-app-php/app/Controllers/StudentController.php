<?php
require_once __DIR__ . "/../Models/Student.php";

class StudentController
{
    private $studentModel;
    public function __construct($db)
    {
        $this->studentModel = new Student($db);
    }
    // Create a method in controller for store student record 
    public function store($first_name, $last_name, $gender, $date_of_birth, $address, $photo_url)
    {
        return $this->studentModel->createStudent($first_name, $last_name, $gender, $date_of_birth, $address, $photo_url);
    }
     // Create a method for show all student records 
    public function show() 
    { 
        return $this->studentModel->getAllStudents(); 
    }

    // Create a method for show a student records by id
    public function showById($id)
    {
        return $this->studentModel->getStudentById($id);
    }

    // Create a method for save updated student record 
    public function update($id, $first_name, $last_name, $gender, $date_of_birth, $address, $photo_url)
    {
        return $this->studentModel->editStudent($id, $first_name, $last_name, $gender, $date_of_birth, $address, $photo_url);
    }
    
    // Create a method for delete a student records by id
    public function destroy($id)
    {
        return $this->studentModel->deleteStudent($id);
    }

    // Create a method for show a student records by keywrod search
    public function showByKeyword($keyword)
    {
        return $this->studentModel->getStudentByKeyword($keyword);
    }
    public function showReport($from, $to){
        return $this->studentModel->getStudentReport($from, $to);

    }
}