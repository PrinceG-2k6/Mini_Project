<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Code/ExamPlan/index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin'; ?> Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/Code/ExamPlan/admin/image/logo.png">
</head>
<body>
    <div class="navbar">
        <div class="navbar-1">
            <img src="/Code/ExamPlan/admin/image/logo.png" alt="logo">
            <div class="navbar-1-content">
                <div class="navbar-1-name">Indian Institute of Information Technology, Nagpur</div>
                <div class="navbar-1-description">An Institution of National Importance by an Act of Parliament</div>
            </div>
        </div>
    </div>
    <div class="back">
        <div class="logout">
            <a href="/Code/ExamPlan/authentication/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
        <div class="Goback">
            <a href="/Code/ExamPlan/admin/index.php">
                <i class="fa-solid fa-right-from-bracket"></i> Go Back
            </a>
        </div>
    </div>
    <div class="view_table">
        <div class="search_tale">
            <form action="" method="POST">
                <h1>Search TimeTable</h1>
                <table>
                    <tr>
                        <td><label for="branch">Branch:</label></td>
                        <td><input type="text" id="branch" name="branch" required></td>
                        
                    </tr>
                    <tr><td><label for="semester">Semester:</label></td>
                    <td><input type="number" name="semester" min="1" max="8" required></td></tr>
                </table>
                <div>
                    <button type="submit" name="view_table" value="view_table">View TimeTable</button>
                    <button type="submit" name="delete_table" value="delete_table">Delete TimeTable</button>
                    <button type="submit" name="export_table" value="export_table" formaction="export_table.php">Export TimeTable</button>
                </div>
            </form>
        </div>
        <div class="show_table">
            <?php
            include "db_config.php";
            if (isset($_POST['view_table'])) {
                $branch = $_POST['branch'];
                $semester = $_POST['semester'];
                try {
                    $sql = "SELECT * FROM exam_timetable WHERE branch = :branch AND semester = :semester ORDER BY Exam_date, start_time";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':branch', $branch, PDO::PARAM_STR);
                    $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        echo "<table>
                                <tr>
                                    <th>Branch</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                    <th>TimeTable</th>
                                </tr>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . (!empty($row['branch']) ? $row['branch'] : 'N/A') . "</td>
                                <td>" . (!empty($row['semester']) ? $row['semester'] : 'N/A') . "</td>
                                <td>" . (!empty($row['subject']) ? $row['subject'] : 'N/A') . "</td>
                                <td>" . (!empty($row['Exam_date']) ? $row['Exam_date'] : 'N/A') . "</td>
                                <td>" . (!empty($row['shift']) ? $row['shift'] : 'N/A') . "</td>
                                <td>" . (!empty($row['start_time']) ? $row['start_time'] : 'N/A') . "</td>
                                <td>" . (!empty($row['end_time']) ? $row['end_time'] : 'N/A') . "</td>
                                <td>
                                <a href='update_row.php?id=" . (!empty($row['subject']) ? $row['subject'] : '') . "'>Edit</a>
                                </td>
                                <td>
                                <form method='POST' class='delete' action='delete_row.php'>
                                    <button name='delete' value='" . (!empty($row['subject']) ? $row['subject'] : '') . "'>Delete</button>
                                </form>
                                </td>
                                <td>
                                <form method='POST' action='show_table.php' class='timetable' action=''>
                                    <a href='show_table.php?branch=" .($row['branch']) . "&semester=" .($row['semester']) . "&examdate=" .($row['Exam_date']) . "&shift=" .($row['shift']) . "'>SHOW</a>
                                
                                </td>
                                </tr>";

                        
                    }
                        echo "</table>";
                    } else {
                        echo "No timetable found.";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>
        </div>
    </div>
    <div class="back">
        <div class="logout">
            <a href="/Code/ExamPlan/authentication/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
        <div class="Goback">
            <a href="/Code/ExamPlan/admin/index.php">
                <i class="fa-solid fa-right-from-bracket"></i> Go Back
            </a>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const deleteButtons = document.querySelectorAll(".delete button");
            deleteButtons.forEach(button => {
                button.addEventListener("click", (event) => {
                    if (!confirm("Are you sure you want to delete this entry?")) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
<?PHP
include "db_config.php";
if(isset($_POST['delete_table']))
{
    try{
        $branch = $_POST['branch'];
        $semester = $_POST['semester'];
        $sql = "DELETE FROM exam_timetable WHERE branch = :branch AND semester = :semester ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':branch', $branch, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
        if($stmt->execute())
        {
            echo "Deleted";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>