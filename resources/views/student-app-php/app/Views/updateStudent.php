<?php
require_once __DIR__ . "/../Controllers/StudentController.php";

$id = $_GET["id"];
$msg = "";

$student = new StudentController($con);

if (isset($_POST['first_name'])) {
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$gender = $_POST["gender"];
$dob = $_POST["date_of_birth"];
$currentAddress = $_POST["address"];

$oldPhoto = $_POST["oldPhoto"];
$newPhotoName = basename($_FILES["photo"]["name"]);
$temp = $_FILES['photo']['tmp_name'];

// Default: keep old photo
$photoDirectory = $oldPhoto;

// Case 1 & 2: no new photo OR same name do nothing
if (!empty($newPhotoName) && $newPhotoName !== basename($oldPhoto)) {
// Case 3: new photo selected and different name
$photoDirectory = "../../public/images/student_photos/" . $newPhotoName;

// Delete old photo if it exists
if (file_exists($oldPhoto)) {
unlink($oldPhoto);
}

// Upload new photo
if (!move_uploaded_file($temp, $photoDirectory)) {
$msg = "<div class='alert alert-danger'>Student update fail (photo upload).</div>";
}
}

$student->update($id, $firstName, $lastName, $gender, $dob, $currentAddress, $photoDirectory);
header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Student</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
<div class="main">
<h1>Update Student Info</h1>
<hr>
<?php
$row = $student->showById($id);
if ($row) {
?>
<form action="" method="post" enctype="multipart/form-data">
<label for="first_name">First Name:</label>
<input type="text" name="first_name" class="form-control" placeholder="Firstname" value="<?php echo $row["first_name"]; ?>">

<label for="last_name">Last Name:</label>
<input type="text" name="last_name" class="form-control" placeholder="Lastname" value="<?php echo $row["last_name"]; ?>">

<p>Select Gender:</p>

<div class="form-check">
<input type="radio" name="gender" id="male" class="form-check-input" value="male" <?php if ($row["gender"] == "male") echo "checked"; ?>>
<label for="male" class="form-check-label">Male</label>
</div>
<div class="form-check">
<input type="radio" name="gender" id="female" class="form-check-input" value="female" <?php if ($row["gender"] == "female") echo "checked"; ?>>
<label for="female" class="form-check-label">Female</label>
</div>
<div class="form-check">
<input type="radio" name="gender" id="other" class="form-check-input" value="other" <?php if ($row["gender"] == "other") echo "checked"; ?>>
<label for="other" class="form-check-label">Other</label>
</div>

<label for="date_of_birth"></label>
<input type="date" name="date_of_birth" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['date_of_birth'])); ?>">

<label for="photoUpload">Choose a photo:</label>
<input type="file" name="photo" class="form-control" id="photoUpload">

<input type="hidden" name="oldPhoto" value="<?php echo $row["photo_url"]; ?>">
                <p>Old photo:</p>
                <p><img src="<?php echo $row["photo_url"]; ?>" alt="" width="150px"></p>

                <label for="address">Address:</label>
                <textarea name="address" class="form-control"><?php echo $row["address"]; ?></textarea> <br>

                <input type="submit" value="Save" class="btn btn-primary">
            </form>
        <?php }
        echo $msg; ?>
    </div>
</body>

</html>
