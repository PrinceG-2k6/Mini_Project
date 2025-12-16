

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="/Code/ExamPlan/admin/style.css">
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
    <div class="msg">
        
        <div class="scrolling-message">
            <h3><p>Hello Students.....What You Want To Do Today </p></h3>
        </div>
        <a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
    <div class="tasks-container">
    <div class="task-box" onclick="location.href='view_plan.php'">
        <i class="fas fa-eye"></i>
        <h3>View Plan</h3>
    </div>
    <!-- <div class="task-box" onclick="location.href='add_student.php'">
        <i class="fas fa-user-graduate"></i>
        <h3>Add Student</h3>
    </div> -->
    <div class="task-box" onclick="location.href='view_timetable.php'">
        <i class="fas fa-eye"></i>
        <h3>View TimeTable</h3>
    </div>
    <div class="task-box" onclick="location.href='/Code/ExamPlan/authentication/logout.php'">
        <i class="fa-solid fa-right-from-bracket"></i>
        <h3>Logout</h3>
    </div>
</div>

    <script>
         window.addEventListener("load", () => {
                document.querySelectorAll(".task-box").forEach((box, index) => {
                    box.style.opacity = "0";
                    box.style.transform = "translateY(20px)";
                    setTimeout(() => {
                        box.style.transition = "all 0.5s ease";
                        box.style.opacity = "1";
                        box.style.transform = "translateY(0)";
                    }, 100 * index);
                });
            });
    </script>
</body>
</html>