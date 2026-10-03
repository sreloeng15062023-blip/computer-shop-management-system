<?php
session_start();
//Check user login
if (!isset($_SESSION['username'])) {
    header("Location: ../../public/index.php");
    exit;
}

 
require_once __DIR__ . "/../Controllers/StudentController.php"; 
 
// Initialize student controller 
$student = new StudentController($con); 
if (isset($_POST['keyword'])) {
    $keyword = $_POST["keyword"];
    $result = $student->showByKeyword($keyword);
} else {
    $result = $student->show();
}

//var_dump($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-SMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="fa-solid fa-graduation-cap"></i> SMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="report.php">Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Setting</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Manage Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <!-- ថែមlogout.phpដើម្បីបានlogout -->
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" action= "" method= "post">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" />
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>


 <!-- Container for display students list --> 
    <div>&nbsp;</div> 
    <div class="container"> 
Prepared by: HONG BUNLEAB  16 | Page 
 
        <table class="table table-striped table-hover"> 
            <tr> 
                <th>#</th> 
                <th>Photo</th> 
                <th>Name</th> 
                <th>Gender</th> 
                <th>Date of Birth</th> 
                <th>Action</th> 
            </tr> 
            <?php 
            $i = 1; 
            foreach ($result as $rows) { 
            ?> 
                <tr> 
                    <td><?php echo $i; ?></td> 
                    <td><img src="<?php echo $rows["photo_url"]; ?>" alt="" 
width="150px"></td> 
                    <td><?php echo $rows["last_name"] . " " . 
$rows["first_name"]; ?></td> 
                    <td><?php echo ucfirst($rows["gender"]); ?></td> 
                    <td><?php echo $rows["date_of_birth"]; ?></td> 
                    <td> 
                          <!-- <a href="">View</a> -->
                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?php echo $rows["student_id"]; ?>"><i class="fa-solid fa-hurricane" style="color: green; font-size:20pt;"></i></a>

                        <a href="updateStudent.php?id=<?php echo $rows["student_id"]; ?>"><i class="fa-solid fa-pencil" style="color: orange; font-size:20pt;"></i></a>

                        <a href="deleteStudent.php?id=<?php echo $rows["student_id"]; ?>" onclick="return confirm('Are sure want to delete?')"><i class="fa-solid fa-trash-can" style="color: red; font-size:20pt;"></i></a>

                    </td> 



                       



 
                </tr> 
            <?php 
                $i++; 
            } 
            ?> 
        </table> 
    </div>


    <!-- Container for create a link to add student -->
    <div class="container">
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                <a href="addStudent.php" class="btn btn-primary">Add New Student</a>
            </div>
            <div class="col">
                
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
                        <div class="col-8 col-sm-6">
                            <p style="text-align: center;"><img id="studentPhoto" src="" width="300px"></p>
                        </div>
                        <div class="col-4 col-sm-6">
                            <p><b>Full Name:</b> <span id="studentName"></span></p>
                            <p><b>Gender:</b> <span id="studentGender"></span></p>
                            <p><b>Date of Birth:</b> <span id="studentDob"></span></p>
                            <p><b>Current Address:</b> <span id="studentAddress"></span></p>
                            <p><b>Created on:</b> <span id="studentCreated"></span></p>
                        </div>
                    </div>
      </div>
      
    </div>
  </div>
</div>
<script src="../../public/js/getStudent.js"></script>
</body>

</html>

