<?php
$host = 'localhost'; // Change if necessary
$db = 'studentdetails'; // Change to your database name
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password

$connection= new mysqli($host, $user, $pass, $db);

$id = "";
$name = "";
$gender = "";
$daysattended = "";
$workingdays = "";
$attendancepercentage = "";
$physicsmarks = "";
$chemistrymarks = "";
$mathmarks = "";
$totalmarks = "";
$percentage = "";
$result = "";
$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET['roll_no'])){
        header("location: /scms/index.php");
        exit;
    }
    $id= $_GET["roll_no"];

    $sql= "SELECT * FROM students WHERE roll_no=$id";
    $status=$connection->query($sql);
    $row=$status->fetch_assoc();

    if(!row){
        header("location: /scms/index.php");
        exit;
    }

$name = $row['name'];
$gender = $row['gender'];
$daysattended = $row['days_attended'];
$workingdays = $row['working_days'];
$attendancepercentage = $row['attendance_percentage'];
$physicsmarks = $row['physics_marks'];
$chemistrymarks = $row['chemistry_marks'];
$mathmarks = $row['math_marks'];
$totalmarks = $row['total_marks'];
$percentage = $row['percentage'];
$result = $row['result'];
}
else{
$id=$row['roll_no'];
$name = $row['name'];
$gender = $row['gender'];
$daysattended = $row['days_attended'];
$workingdays = $row['working_days'];
$attendancepercentage = $row['attendance_percentage'];
$physicsmarks = $row['physics_marks'];
$chemistrymarks = $row['chemistry_marks'];
$mathmarks = $row['math_marks'];
$totalmarks = $row['total_marks'];
$percentage = $row['percentage'];
$result = $row['result'];

do{
    if (empty($id) || empty($name) || empty($gender) || empty($daysattended) || 
    empty($workingdays) || empty($attendancepercentage) || empty($physicsmarks) || 
    empty($chemistrymarks) || empty($mathmarks) || empty($totalmarks) || 
    empty($percentage) || empty($result)) {
    
    $errorMessage = "All fields are required!";
    break;
}

$sql="UPDATE students SET name = $name, gender = $gender, days_attended = $daysattended, working_days = $workingdays, attendance_percentage = $attendancepercentage, physics_marks = $physicsmarks, chemistry_marks = $chemistrymarks, math_marks = $mathmarks, total_marks = $totalmarks, percentage = $percentage, result = $result WHERE roll_no = $id";
$status=$connection->query($sql);
if(!$status){
    $errorMessage = "Error updating student details!";
    break;
    }
    $successMessage = "Student details updated successfully!";
    header("location: /scms/index.php");
    exit;
}while(false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>New Student Details</h2>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissable fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" value="<?php echo htmlspecialchars($id); ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Roll No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Fixed here -->
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="gender" value="<?php echo htmlspecialchars($gender); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Days Attended</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="daysattended" value="<?php echo htmlspecialchars($daysattended); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Working Days</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="workingdays" value="<?php echo htmlspecialchars($workingdays); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Attendance Percentage</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="attendancepercentage" value="<?php echo htmlspecialchars($attendancepercentage); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Physics Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="physicsmarks" value="<?php echo htmlspecialchars($physicsmarks); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Chemistry Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="chemistrymarks" value="<?php echo htmlspecialchars($chemistrymarks); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Math Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="mathmarks" value="<?php echo htmlspecialchars($mathmarks); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Total Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="totalmarks" value="<?php echo htmlspecialchars($totalmarks); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Percentage</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="percentage" value="<?php echo htmlspecialchars($percentage); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Result</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="result" value="<?php echo htmlspecialchars($result); ?>">
                </div>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-6">
                        <div class="alert alert-success alert-dismissable fade show" role="alert">
                            <strong><?php echo $successMessage; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/scms/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-DfXdzj1hboHnjHfT1Z7d06mHTaKxIFZV8efBAt2s2x+Um5gUkZmxK+tc1zqF8dY8" crossorigin="anonymous"></script>
</body>
</html>
