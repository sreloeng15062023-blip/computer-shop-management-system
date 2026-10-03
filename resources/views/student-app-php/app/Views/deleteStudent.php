<?php
require_once __DIR__ . "/../Controllers/StudentController.php";

$student = new StudentController($con);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get student record first
    $studentData = $student->showById($id);

    // Delete photo if it exists
    if (!empty($studentData["photo_url"]) && file_exists($studentData["photo_url"])) {
        unlink($studentData["photo_url"]);
    }

    // Delete student record
    $result = $student->destroy($id);

    if ($result) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Failed to delete student record.</div>";
    }



    
}