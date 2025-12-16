<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Code/ExamPlan/index.html");
    exit();
}
?>

<?php
include("db_config.php");

if (isset($_GET['id'])) {
    $subject = $_GET['id'];
    $rooms = $conn->prepare("SELECT * FROM exam_timetable WHERE subject = '$subject'");
    $rooms->execute();
    $room = $rooms->fetchAll();

    $Exam_date = $room[0]['Exam_date'];
    $shift = $room[0]['shift'];
    $branch = $room[0]['branch'];
    $start_time = $room[0]['start_time'];
    $end_time = $room[0]['end_time'];
    $semester = $room[0]['semester'];
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin'; ?> Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <div class="update_row">
        <form action="" method="POST">
            <div class="form-group">
                <label>Branch:</label>
                <select name="branch" required>
                    <option value="">Select</option>
                    <option value="CSE" <?php echo ($branch == 'CSE') ? 'selected' : ''; ?>>CSE</option>
                    <option value="CSD" <?php echo ($branch == 'CSD') ? 'selected' : ''; ?>>CSD</option>
                    <option value="CSA" <?php echo ($branch == 'CSA') ? 'selected' : ''; ?>>CSA</option>
                    <option value="CSH" <?php echo ($branch == 'CSH') ? 'selected' : ''; ?>>CSH</option>
                    <option value="ECE" <?php echo ($branch == 'ECE') ? 'selected' : ''; ?>>ECE</option>
                    <option value="ECI" <?php echo ($branch == 'ECI') ? 'selected' : ''; ?>>ECI</option>
                </select>
            </div>
            <div class="form-group">
                <label>Semester:</label>
                <input type="number" name="semester" min="1" max="8" value="<?php echo htmlspecialchars($semester); ?>" placeholder="Enter Semester" required>
            </div>
            <div class="form-group">
                <label>Subject:</label>
                <input type="text" name="subject" value="<?php echo htmlspecialchars($subject); ?>" placeholder="Enter Subject" required>
            </div>
            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="exam_date" value="<?php echo htmlspecialchars($Exam_date); ?>" required>
            </div>
            <div class="form-group">
                <label>Shift:</label>
                <select name="shift" required>
                    <option value="">Select</option>
                    <option value="Morning" <?php echo ($shift == 'Morning') ? 'selected' : ''; ?>>Morning</option>
                    <option value="Evening" <?php echo ($shift == 'Evening') ? 'selected' : ''; ?>>Evening</option>
                </select>
            </div>
            <div class="form-group">
                <label>Start Time:</label>
                <input type="time" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>" required>
            </div>
            <div class="form-group">
                <label>End Time:</label>
                <input type="time" name="end_time" value="<?php echo htmlspecialchars($end_time); ?>" required>
            </div>
            <button type="submit" name="update">UPDATE Timetable</button>
        </form>
    </div>
                
        
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/manage_room.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector("form");
            const inputs = form.querySelectorAll("input, select");

            // Add real-time validation
            inputs.forEach(input => {
                input.addEventListener("input", () => {
                    if (input.checkValidity()) {
                        input.style.borderColor = "green";
                    } else {
                        input.style.borderColor = "red";
                    }
                });
            });

            // Confirm before submitting the form
            form.addEventListener("submit", (e) => {
                const confirmation = confirm("Are you sure you want to update the timetable?");
                if (!confirmation) {
                    e.preventDefault();
                }
            });

            // Add a reset button functionality
            const resetButton = document.createElement("button");
            resetButton.type = "button";
            resetButton.textContent = "Reset Form";
            resetButton.style.marginLeft = "10px";
            form.appendChild(resetButton);

            resetButton.addEventListener("click", () => {
                if (confirm("Are you sure you want to reset the form?")) {
                    form.reset();
                    inputs.forEach(input => input.style.borderColor = "");
                }
            });
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];
    $exam_date = $_POST['exam_date'];
    $shift = $_POST['shift'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $update_query = $conn->prepare("UPDATE exam_timetable SET branch = ?, semester = ?, subject = ?, Exam_date = ?, shift = ?, start_time = ?, end_time = ? WHERE subject = ?");
    $update_query->execute([$branch, $semester, $subject, $exam_date, $shift, $start_time, $end_time, $subject]);

    if ($update_query) {
        echo "<script>alert('Timetable updated successfully!'); window.location.href='/Code/ExamPlan/admin/view_timetable.php';</script>";
    } else {
        echo "<script>alert('Failed to update timetable. Please try again.');</script>";
    }
}

?>
