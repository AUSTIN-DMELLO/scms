<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "studentdetails";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Build the query for downloading all students
$query = "SELECT * FROM students";
$result = $connection->query($query);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Set headers to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="studentsdetails.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Roll No', 'Name', 'Gender', 'Days Attended', 'Working Days', 'Attendance Percentage', 'Physics Marks', 'Chemistry Marks', 'Math Marks', 'Total', 'Percentage', 'Result']);

// Fetch and write each row to the CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
