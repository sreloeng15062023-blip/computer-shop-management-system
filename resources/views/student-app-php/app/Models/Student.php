<?php
require_once __DIR__ . "/../../config/database.php";

class Student
{
    private $db;
    //Create a constructor for auto run connection when call this class
    public function __construct($con)
    {
        $this->db = $con;
    }

    //Create a method to insert student into database
    public function createStudent($first_name, $last_name, $gender, $date_of_birth, $address, $photo_url)
    {
        $stmt = $this->db->prepare("INSERT INTO students(first_name, last_name, gender, date_of_birth, address, photo_url) VALUES(:fn, :ln, :gd, :db, :ad, :pu)");
        $stmt->bindParam(':fn', $first_name);
        $stmt->bindParam(':ln', $last_name);
        $stmt->bindParam(':gd', $gender);
        $stmt->bindParam(':db', $date_of_birth);
        $stmt->bindParam(':ad', $address);
        $stmt->bindParam(':pu', $photo_url);
        $stmt->execute();
    }

     //Create a method to select all student records from database 
    public function getAllStudents() 
    { 
        $stmt = $this->db->prepare("SELECT * FROM students"); 
        $stmt->execute(); 
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        return $rows; 
    }

    //Create a method to select a single record of student from database
    public function getStudentById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE student_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    

    //Create a method to edit student 
    public function editStudent($id, $first_name, $last_name, $gender, $date_of_birth, $address, $photo_url)
    {
        $stmt = $this->db->prepare("UPDATE students SET first_name = :fn, last_name = :ln, gender = :gd, date_of_birth = :db, address = :ad, photo_url = :pu WHERE student_id = :id");
        $stmt->bindParam(':fn', $first_name);
        $stmt->bindParam(':ln', $last_name);
        $stmt->bindParam(':gd', $gender);
        $stmt->bindParam(':db', $date_of_birth);
        $stmt->bindParam(':ad', $address);
        $stmt->bindParam(':pu', $photo_url);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    //Create a method to delete a record of student from database
    public function deleteStudent($id)
    {
        $stmt = $this->db->prepare("DELETE FROM students WHERE student_id = :id");
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // return true if a row was deleted 
        }
        return false;
    }
    //Create a method to search student from database
    public function getStudentByKeyword($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $stmt = $this->db->prepare("SELECT * FROM students WHERE first_name LIKE :kw OR last_name LIKE :kw");
        $stmt->bindParam(':kw', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    //Create a method to filter student report
    public function getStudentReport($from, $to)
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE DATE(created_at) BETWEEN :fr AND :tt");
        $stmt->bindParam(':fr', $from);
        $stmt->bindParam(':tt', $to);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
}

