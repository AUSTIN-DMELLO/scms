<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "studentdetails";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch the student data to edit
if (isset($_GET['Roll_No'])) {
    $roll_no = $_GET['Roll_No'];
    $stmt = $connection->prepare("SELECT * FROM students WHERE Roll_No = ?");
    $stmt->bind_param('s', $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
} else {
    // Redirect if Roll_No is not provided
    header('Location: /scms/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $roll_no = $_POST['Roll_No'];
    $name = $_POST['Name'];
    $gender = $_POST['Gender'];
    $days_attended = $_POST['Days_Attended'];
    $working_days = $_POST['Working_Days'];
    $attendance_percentage = $_POST['Attendance_Percentage'];
    $physics_marks = $_POST['Physics_Marks'];
    $chemistry_marks = $_POST['Chemistry_Marks'];
    $math_marks = $_POST['Math_Marks'];
    $total_marks = $_POST['Total_Marks'];
    $percentage = $_POST['Percentage'];
    $result = $_POST['Result']; // Make sure this is set to either "Pass" or "Fail"

    // Prepare the update statement
    $stmt = $connection->prepare("UPDATE students SET Name=?, Gender=?, Days_Attended=?, Working_Days=?, Attendance_Percentage=?, Physics_Marks=?, Chemistry_Marks=?, Math_Marks=?, Total_Marks=?, Percentage=?, Result=? WHERE Roll_No=?");
    $stmt->bind_param('ssiiidddddds', $name, $gender, $days_attended, $working_days, $attendance_percentage, $physics_marks, $chemistry_marks, $math_marks, $total_marks, $percentage, $result, $roll_no);
    
    // Execute the statement and check for success
    if ($stmt->execute()) {
        header('Location: /scms/index.php'); // Redirect to the student details page
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
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
        <form method="POST">
            <input type="hidden" name="Roll_No" value="<?php echo htmlspecialchars($student['Roll_No']); ?>">
            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" name="Name" value="<?php echo htmlspecialchars($student['Name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Gender" class="form-label">Gender</label>
                <select class="form-select" name="Gender" required>
                    <option value="Male" <?php echo ($student['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($student['Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Days_Attended" class="form-label">Days Attended</label>
                <input type="number" class="form-control" name="Days_Attended" value="<?php echo htmlspecialchars($student['Days_Attended']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Working_Days" class="form-label">Working Days</label>
                <input type="number" class="form-control" name="Working_Days" value="<?php echo htmlspecialchars($student['Working_Days']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Attendance_Percentage" class="form-label">Attendance Percentage</label>
                <input type="number" class="form-control" name="Attendance_Percentage" value="<?php echo htmlspecialchars($student['Attendance_Percentage']); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="Physics_Marks" class="form-label">Physics Marks</label>
                <input type="number" class="form-control" name="Physics_Marks" value="<?php echo htmlspecialchars($student['Physics_Marks']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Chemistry_Marks" class="form-label">Chemistry Marks</label>
                <input type="number" class="form-control" name="Chemistry_Marks" value="<?php echo htmlspecialchars($student['Chemistry_Marks']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Math_Marks" class="form-label">Math Marks</label>
                <input type="number" class="form-control" name="Math_Marks" value="<?php echo htmlspecialchars($student['Math_Marks']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Total_Marks" class="form-label">Total Marks</label>
                <input type="number" class="form-control" name="Total_Marks" value="<?php echo htmlspecialchars($student['Total_Marks']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Percentage" class="form-label">Percentage</label>
                <input type="number" class="form-control" name="Percentage" value="<?php echo htmlspecialchars($student['Percentage']); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="Result" class="form-label">Result</label>
                <select class="form-select" name="Result" required>
                    <option value="Pass" <?php echo ($student['Result'] == 'Pass') ? 'selected' : ''; ?>>Pass</option>
                    <option value="Fail" <?php echo ($student['Result'] == 'Fail') ? 'selected' : ''; ?>>Fail</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
            <a class='btn btn-primary' href='/scms/index.php'>Cancel</a>
        </form>
    </div>
</body>
</html>
