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
        <h2>Student Details</h2>
        <div class="mb-3">
            <a class="btn btn-primary me-2" href="/scms/create.php" role="button">Add Student Details</a>
            <a href="/scms/download_csv.php" class="btn btn-success">Download CSV Report</a>
        </div>
        
        <!-- Search and Filter Form -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Search by name or roll number">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="result_filter">
                        <option value="">Select Result</option>
                        <option value="pass">Pass</option>
                        <option value="fail">Fail</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="percentage_filter">
                        <option value="">Select Percentage Condition</option>
                        <option value="greater">Greater than</option>
                        <option value="less">Less than</option>
                        <option value="equal">Equal to</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="percentage_value" placeholder="Percentage Value">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <label for="math_marks">Math Marks:</label>
                    <select class="form-select" name="math_marks_condition">
                        <option value="">Select Condition</option>
                        <option value="greater">Greater than</option>
                        <option value="less">Less than</option>
                        <option value="equal">Equal to</option>
                    </select>
                    <input type="number" class="form-control mt-1" name="math_marks" placeholder="Marks">
                </div>
                <div class="col-md-3">
                    <label for="phy_marks">Physics Marks:</label>
                    <select class="form-select" name="phy_marks_condition">
                        <option value="">Select Condition</option>
                        <option value="greater">Greater than</option>
                        <option value="less">Less than</option>
                        <option value="equal">Equal to</option>
                    </select>
                    <input type="number" class="form-control mt-1" name="phy_marks" placeholder="Marks">
                </div>
                <div class="col-md-3">
                    <label for="chem_marks">Chemistry Marks:</label>
                    <select class="form-select" name="chem_marks_condition">
                        <option value="">Select Condition</option>
                        <option value="greater">Greater than</option>
                        <option value="less">Less than</option>
                        <option value="equal">Equal to</option>
                    </select>
                    <input type="number" class="form-control mt-1" name="chem_marks" placeholder="Marks">
                </div>
                <div class="col-md-3">
                    <label for="attendance">Attendance Percentage:</label>
                    <select class="form-select" name="attendance_condition">
                        <option value="">Select Condition</option>
                        <option value="greater">Greater than</option>
                        <option value="less">Less than</option>
                        <option value="equal">Equal to</option>
                    </select>
                    <input type="number" class="form-control mt-1" name="attendance" placeholder="Attendance Percentage">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <label for="total_marks">Total Marks:</label>
                    <select class="form-select" name="total_marks_condition">
                        <option value="">Select Condition</option>
                        <option value="greater">Greater than</option>
                        <option value="less">Less than</option>
                        <option value="equal">Equal to</option>
                    </select>
                    <input type="number" class="form-control mt-1" name="total_marks" placeholder="Marks">
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Days Attended</th>
                    <th>Working Days</th>
                    <th>Attendance Percentage</th>
                    <th>Physics Marks</th>
                    <th>Chemistry Marks</th>
                    <th>Math Marks</th>
                    <th>Total</th>
                    <th>Percentage</th>
                    <th>Result</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "studentdetails";

                    $connection = new mysqli($servername, $username, $password, $database);

                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }

                    // Build query based on filters
                    $query = "SELECT * FROM students WHERE 1=1";
                    $params = [];

                    // Search filter
                    if (!empty($_GET['search'])) {
                        $search = $connection->real_escape_string($_GET['search']);
                        $query .= " AND (Roll_No LIKE ? OR Name LIKE ?)";
                        $params[] = "%$search%";
                        $params[] = "%$search%";
                    }

                    // Result filter
                    if (!empty($_GET['result_filter'])) {
                        $result_filter = $_GET['result_filter'];
                        if ($result_filter == "pass") {
                            $query .= " AND Result = 'Pass'";
                        } elseif ($result_filter == "fail") {
                            $query .= " AND Result = 'Fail'";
                        }
                    }

                    // Percentage filter
                    if (!empty($_GET['percentage_filter']) && !empty($_GET['percentage_value'])) {
                        $percentage_filter = $_GET['percentage_filter'];
                        $percentage_value = (int)$_GET['percentage_value'];

                        if ($percentage_filter == "greater") {
                            $query .= " AND Percentage > ?";
                        } elseif ($percentage_filter == "less") {
                            $query .= " AND Percentage < ?";
                        } elseif ($percentage_filter == "equal") {
                            $query .= " AND Percentage = ?";
                        }
                        $params[] = $percentage_value;
                    }

                    // Marks filters
                    foreach (['math_marks', 'phy_marks', 'chem_marks'] as $subject) {
                        if (!empty($_GET[$subject]) && !empty($_GET[$subject . '_condition'])) {
                            $condition = $_GET[$subject . '_condition'];
                            $value = (int)$_GET[$subject];

                            if ($condition == "greater") {
                                $query .= " AND $subject > ?";
                            } elseif ($condition == "less") {
                                $query .= " AND $subject < ?";
                            } elseif ($condition == "equal") {
                                $query .= " AND $subject = ?";
                            }
                            $params[] = $value;
                        }
                    }

                    // Attendance filter
                    if (!empty($_GET['attendance']) && !empty($_GET['attendance_condition'])) {
                        $attendance_condition = $_GET['attendance_condition'];
                        $attendance_value = (int)$_GET['attendance'];

                        if ($attendance_condition == "greater") {
                            $query .= " AND Attendance_Percentage > ?";
                        } elseif ($attendance_condition == "less") {
                            $query .= " AND Attendance_Percentage < ?";
                        } elseif ($attendance_condition == "equal") {
                            $query .= " AND Attendance_Percentage = ?";
                        }
                        $params[] = $attendance_value;
                    }

                    // Total Marks filter
                    if (!empty($_GET['total_marks']) && !empty($_GET['total_marks_condition'])) {
                        $total_marks_condition = $_GET['total_marks_condition'];
                        $total_marks_value = (int)$_GET['total_marks'];

                        if ($total_marks_condition == "greater") {
                            $query .= " AND Total_Marks > ?";
                        } elseif ($total_marks_condition == "less") {
                            $query .= " AND Total_Marks < ?";
                        } elseif ($total_marks_condition == "equal") {
                            $query .= " AND Total_Marks = ?";
                        }
                        $params[] = $total_marks_value;
                    }

                    // Prepare and execute the query
                    $stmt = $connection->prepare($query);
                    if (!empty($params)) {
                        $types = str_repeat('s', count($params)); // Adjust types accordingly
                        $stmt->bind_param($types, ...$params);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }

                    // Fetch and display the results
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['Roll_No']}</td>
                            <td>{$row['Name']}</td>
                            <td>{$row['Gender']}</td>
                            <td>{$row['Days_Attended']}</td>
                            <td>{$row['Working_Days']}</td>
                            <td>{$row['Attendance_Percentage']}</td>
                            <td>{$row['Physics_Marks']}</td>
                            <td>{$row['Chemistry_Marks']}</td>
                            <td>{$row['Math_Marks']}</td>
                            <td>{$row['Total_Marks']}</td>
                            <td>{$row['Percentage']}</td>
                            <td>{$row['Result']}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='/scms/edit.php?Roll_No={$row['Roll_No']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='/scms/delete.php?Roll_No={$row['Roll_No']}'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
