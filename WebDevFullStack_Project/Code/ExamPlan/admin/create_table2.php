
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
    <div class="create_table">
    <h2>Exam Timetable Generator</h2>
    <form id="timetableForm" action="" method="POST">

        <div class="form-group">
            <label >Subject :
            <?php    
            include("db_config.php");
                $getsubjects  = $conn->prepare("SELECT subject FROM subjects WHERE branch = :branch AND semester = :semester");
                $getsubjects->bindParam(':semester', $_SESSION['semester'], PDO::PARAM_INT);
                $getsubjects->bindParam(':branch', $_SESSION['branch'], PDO::PARAM_STR);
                $getsubjects->execute();
                $subjectData = $getsubjects->fetchAll();
                // print_r($subjectData);  

                echo "<select name='subject'>";
                foreach($subjectData as $subject)
                {
                    echo "<option value=".$subject['subject'].">".$subject['subject']."</option>";
                }

                echo "</select>";
            ?>
                </label>
        </div>

        <div class="form-group">
            <label for="exam_date">Date:</label>
            <input type="date" name="exam_date" id="exam_date" required>
        </div>
        <div class="form-group">
            <label for="shift">shift:</label>
            <select name="shift" id="shift" required>
                <option value="">Select</option>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
                
            </select>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time:</label>
            <input type="time" name="end_time" id="end_time" required>
        </div>

        <button type="submit" name="add_table">Add Timetable</button>
    </form>
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
            const form = document.getElementById("timetableForm");

            form.addEventListener("submit", (event) => {
                const startTime = form.querySelector('input[name="start_time"]').value;
                const endTime = form.querySelector('input[name="end_time"]').value;

                if (startTime >= endTime) {
                    event.preventDefault();
                    alert("End Time must be later than Start Time.");
                }
            });


            const inputs = form.querySelectorAll("input, select");
            inputs.forEach(input => {
                input.addEventListener("input", () => {
                    input.style.borderColor = "green";
                });
            });
        });
    </script>
</body>
</html>

<?php
include "db_config.php";
if(isset($_POST['add_table']))
{
$semester = $_SESSION['semester'];
$branch =$_SESSION['branch'];
$shift = $_POST['shift'];
$subject = $_POST['subject'];
$exam_date = $_POST['exam_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

try {
    $sql = "INSERT INTO exam_timetable (branch, semester, subject, Exam_date, shift ,start_time, end_time)
            VALUES (:branch, :semester, :subject, :exam_date, :shift, :start_time, :end_time)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':branch', $branch); 
    $stmt->bindParam(':shift', $shift); 
    $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':exam_date', $exam_date);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);

    if ($stmt->execute()) {
        echo "<script>
        alert('Data Created');
        </script>";
    } else {
        echo "Error: Could not execute the query.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
}
?>
