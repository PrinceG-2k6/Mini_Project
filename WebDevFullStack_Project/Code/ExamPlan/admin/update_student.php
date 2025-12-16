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
    $id = $_GET['id'];
    $getusers = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $getusers->bindParam(':id', $id, PDO::PARAM_INT);
    $getusers->execute();
    $users = $getusers->fetchAll();

    $role = $users[0]['role'];

    if ($role == 'admin') {
        $getadmin = $conn->prepare("SELECT * FROM admin WHERE admin_id = :id");
        $getadmin->bindParam(':id', $id, PDO::PARAM_INT);
        $getadmin->execute();
        $admin = $getadmin->fetchAll();

        $admin_id = $id;
        $name = $_GET['name'];
        $email = $_GET['email'];
    } else {
        $getstudents = $conn->prepare("SELECT * FROM students WHERE user_id = :id");
        $getstudents->bindParam(':id', $id, PDO::PARAM_INT);
        $getstudents->execute();
        $students = $getstudents->fetchAll();

        $user_id = $id;
        $name = $students[0]['name'];
        $roll_no = $students[0]['roll_no'];
        $branch = $students[0]['branch'];
        $email = $students[0]['email'];
        $year = $students[0]['year'];
    }
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
    <div class="update">
        <?php if ($role == 'student'): ?>
            <form action="" method="POST">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>" readonly>
                <br><br>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <br><br>

                <label for="roll_no">Roll Number:</label>
                <input type="text" id="roll_no" name="roll_no" value="<?php echo $roll_no; ?>">
                <br><br>
                
                <label for="branch">Branch:</label>
                <input type="text" id="branch" name="branch" value="<?php echo $branch; ?>">
                <br><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <br><br>
                
                <label for="year">Year:</label>
                <select name="year" id="year">
                    <option value="First" <?php echo ($year == 'First') ? 'selected' : ''; ?>>1st</option>
                    <option value="Second" <?php echo ($year == 'Second') ? 'selected' : ''; ?>>2nd</option>
                    <option value="Third" <?php echo ($year == 'Third') ? 'selected' : ''; ?>>3rd</option>
                    <option value="Fourth" <?php echo ($year == 'Fourth') ? 'selected' : ''; ?>>4th</option>
                </select>
                <br><br>
                
                <button value="<?php echo $id; ?>" name="update">Update Data</button>
            </form>
        <?php endif; ?>

        <?php if ($role == 'admin'): ?>
            <form action="" method="POST">
                <label for="admin_id">Admin ID:</label>
                <input type="text" id="admin_id" name="admin_id" value="<?php echo $admin_id; ?>" readonly>
                <br><br>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <br><br>
                
                <button value="<?php echo $id; ?>" name="update">Update Data</button>
            </form>
        <?php endif; ?>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const inputs = document.querySelectorAll("input, select");

            // Add focus and blur effects for better UI
            inputs.forEach(input => {
                input.addEventListener("focus", () => {
                    input.style.border = "2px solid #4CAF50";
                    input.style.backgroundColor = "#f9f9f9";
                });

                input.addEventListener("blur", () => {
                    input.style.border = "1px solid #ccc";
                    input.style.backgroundColor = "#fff";
                });
            });

            // Confirmation before submitting the form
            const updateButtons = document.querySelectorAll("button[name='update']");
            updateButtons.forEach(button => {
                button.addEventListener("click", (event) => {
                    const confirmUpdate = confirm("Are you sure you want to update the data?");
                    if (!confirmUpdate) {
                        event.preventDefault();
                    }
                });
            });

            // Auto-scroll to the form on page load
            const updateSection = document.querySelector(".update");
            if (updateSection) {
                updateSection.scrollIntoView({ behavior: "smooth" });
            }
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['update']) && $role == 'student') {
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $year = $_POST['year'];

    $update = $conn->prepare("UPDATE students SET
        name = :name,
        branch = :branch,
        roll_no = :roll_no,
        email = :email,
        year = :year
        WHERE user_id = :id");
    $update->bindParam(':name', $name);
    $update->bindParam(':branch', $branch);
    $update->bindParam(':roll_no', $roll_no);
    $update->bindParam(':email', $email);
    $update->bindParam(':year', $year);
    $update->bindParam(':id', $id);

    if ($update->execute()) {
        header("Location: manage_users.php");
    } else {
        echo "Update Failed";
    }
}

if (isset($_POST['update']) && $role == 'admin') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update = $conn->prepare("UPDATE admin SET
        name = :name,
        email = :email
        WHERE admin_id = :id");
    $update->bindParam(':name', $name);
    $update->bindParam(':email', $email);
    $update->bindParam(':id', $id);

    if ($update->execute()) {
        header("Location: manage_users.php");
    } else {
        echo "Update Failed";
    }
}
?>
