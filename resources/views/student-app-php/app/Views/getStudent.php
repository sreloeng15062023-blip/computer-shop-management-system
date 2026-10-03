<?php
require_once __DIR__ . "/../Controllers/StudentController.php";

$student = new StudentController($con);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $student->showById($id);

    header("Content-Type: application/json");
    echo json_encode($result);
}
