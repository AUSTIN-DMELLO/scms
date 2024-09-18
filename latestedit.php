<?php
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

// Database connection parameters
$host = 'localhost'; // Change if necessary
$db = 'studentdetails'; // Change to your database name
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id'])) {
        header("location: /scms/index.php");
        exit;
    }
    $id = $_GET['id'];

    // Retrieve existing student details
    $stmt = $pdo->prepare("SELECT * FROM students WHERE roll_no = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $daysattended = $_POST['daysattended'];
    $workingdays = $_POST['workingdays'];
    $attendancepercentage = $_POST['attendancepercentage'];
    $physicsmarks = $_POST['physicsmarks'];
    $chemistrymarks = $_POST['chemistrymarks'];
    $mathmarks = $_POST['mathmarks'];
    $totalmarks = $_POST['totalmarks'];
    $percentage = $_POST['percentage'];
    $result = $_POST['result'];

    // Validate inputs
    if (empty($id) || empty($name) || empty($gender) || empty($daysattended) || 
        empty($workingdays) || empty($attendancepercentage) || empty($physicsmarks) || 
        empty($chemistrymarks) || empty($mathmarks) || empty($totalmarks) || 
        empty($percentage) || empty($result)) {
        
        $errorMessage = "All fields are required!";
    } else {
        // Update in the database
        $stmt = $pdo->prepare("UPDATE students SET name = ?, gender = ?, days_attended = ?, working_days = ?, attendance_percentage = ?, physics_marks = ?, chemistry_marks = ?, math_marks = ?, total_marks = ?, percentage = ?, result = ? WHERE roll_no = ?");
        
        if ($stmt->execute([$name, $gender, $daysattended, $workingdays, $attendancepercentage, $physicsmarks, $chemistrymarks, $mathmarks, $totalmarks, $percentage, $result, $id])) {
            $successMessage = "Student details updated successfully!";
            header("location: /scms/index.php");
            exit;
        } else {
            $errorMessage = "Error updating student details.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Student Details</h2>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissable fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Roll No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="roll_no" value="<?php echo htmlspecialchars($id); ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="gender" value="<?php echo htmlspecialchars($gender); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Days Attended</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="daysattended" value="<?php echo htmlspecialchars($daysattended); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Working Days</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="workingdays" value="<?php echo htmlspecialchars($workingdays); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Attendance Percentage</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="attendancepercentage" value="<?php echo htmlspecialchars($attendancepercentage); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Physics Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="physicsmarks" value="<?php echo htmlspecialchars($physicsmarks); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Chemistry Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="chemistrymarks" value="<?php echo htmlspecialchars($chemistrymarks); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Math Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="mathmarks" value="<?php echo htmlspecialchars($mathmarks); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Total Marks</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="totalmarks" value="<?php echo htmlspecialchars($totalmarks); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Percentage</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="percentage" value="<?php echo htmlspecialchars($percentage); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Result</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="result" value="<?php echo htmlspecialchars($result); ?>" required>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/scms/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
