
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
            <label>Branch:</label>
            <select name="branch" required>
                <option value="">Select</option>
                <option value="CSE">CSE</option>
                <option value="CSD">CSD</option>
                <option value="CSA">CSA</option>
                <option value="CSH">CSH</option>
                <option value="ECE">ECE</option>
                <option value="ECI">ECI</option>
                
            </select>
        </div>

        <div class="form-group">
            <label>Semester:</label>
            <input type="number" name="semester" min="1" max="8" required>
        </div>

        <button type="submit" name="gen_table">Create Timetable</button>
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
<?PHP
if(isset($_POST['gen_table']))
{
    $_SESSION['semester']=$_POST["semester"];
$_SESSION['branch']=$_POST['branch'];

header("Location: create_table2.php");
}
?>