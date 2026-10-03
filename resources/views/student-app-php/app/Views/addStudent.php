
<?php
session_start();
//Check user login
if (!isset($_SESSION['username'])) {
    header("Location: ../../public/index.php");
    exit;
}
require_once __DIR__ . "/../Controllers/StudentController.php";

$msg = "";

if (isset($_POST['first_name'])) {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $gender = $_POST["gender"];
    $dob = $_POST["date_of_birth"];
    $address = $_POST["address"];


    // Photo upload directory
    $photoDirectory = "../../public/images/student_photos/" . basename($_FILES["photo"]["name"]);
    $temp = $_FILES['photo']['tmp_name'];

    // Initialize controller to use method store student
    $student = new StudentController($con);

    if (move_uploaded_file($temp, $photoDirectory)) {
        // Insert into students table
        $student->store($firstName, $lastName, $gender, $dob, $address, $photoDirectory);
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Student insert failed.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <style>
        .main {
            width: 500px;
            margin: 0 auto;
            border: 1px solid silver;
            border-radius: 20px;
            padding: 20px;
        }

        input {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="main">
        <h1>Add a New Student</h1>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" class="form-control" placeholder="Firstname">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control" placeholder="Lastname">

            <p>Select Gender:</p>
            <div class="form-check">
                <input type="radio" name="gender" id="male" class="form-check-input" value="male" required>
                <label for="male" class="form-check-label">Male</label>
            </div>
            <div class="form-check">
                <input type="radio" name="gender" id="female" class="form-check-input" value="female">
                <label for="female" class="form-check-label">Female</label>
            </div>
            <div class="form-check">
                <input type="radio" name="gender" id="other" class="form-check-input" value="other">
                <label for="other" class="form-check-label">Other</label>
            </div>

            <label for="date_of_birth"></label>
            <input type="date" name="date_of_birth" class="form-control">

            <label for="photo">Choose a photo:</label>
            <input type="file" name="photo" class="form-control" id="photoUpload">

            <label for="address">Address:</label>
            <textarea name="address" class="form-control"></textarea> <br>

            <input type="submit" value="Save" class="btn btn-primary">
        </form>
        <?php echo $msg; ?>
    </div>
</body>
</html>