<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Code/ExamPlan/index.html");
    exit();
}
$id = $_SESSION['user_id'];
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
    <div class="change_password">        
        <form action='' method='POST'>
            <label for="cu_password">Enter Your Current Password :</label>
            <input type="password" name="cu_password" id="cu_password"><br><br>
            <button type='submit'>Submit</button>
            <?php
            include("./db_config.php");
            if (isset($_POST['cu_password'])) {
                $getuser = $conn->prepare("SELECT password FROM users WHERE id = '$id'");
                $getuser->execute();
                $user = $getuser->fetchAll();
                $password = $user[0]['password'];
                if (!isset($_POST['Npassword']) && $_POST['cu_password'] == $password) {
                    echo "<br><h3>Now You Can Change Your Password</h3><br><br>";
                    $i = 1;
                }
            }
            ?>

            <?php if (isset($i) && $i == 1): ?>
                <form action="" method="POST">
                    <table>
                        <tr>
                            <td><label for="Npassword">New Password :</label></td>
                            <td><input type="text" name="Npassword" id="Npassword" required></td>
                        </tr>
                        <tr>
                            <td><label for="Cpassword">Confirm Password :</label></td>
                            <td><input type="password" name="Cpassword" id="Cpassword" required></td>
                        </tr>
                    </table>
                    <button type="submit">Change Password</button>
                </form>
            <?php endif; ?>
        </form>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const currentPasswordInput = document.getElementById("cu_password");
            const newPasswordInput = document.getElementById("Npassword");
            const confirmPasswordInput = document.getElementById("Cpassword");

            // Add real-time password matching validation
            if (newPasswordInput && confirmPasswordInput) {
                confirmPasswordInput.addEventListener("input", () => {
                    if (newPasswordInput.value !== confirmPasswordInput.value) {
                        confirmPasswordInput.style.borderColor = "red";
                        confirmPasswordInput.setCustomValidity("Passwords do not match");
                    } else {
                        confirmPasswordInput.style.borderColor = "green";
                        confirmPasswordInput.setCustomValidity("");
                    }
                });
            }
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['Npassword'])) {
    if ($_POST['Npassword'] == $_POST['Cpassword']) {
        $new_password = $_POST['Npassword'];
        $update_password = $conn->prepare("UPDATE users SET password = '$new_password' WHERE id = '$id'");
        if ($update_password->execute()) {
            echo "<h4 align='center'>Password Changed Successfully!</h4>";
        } else {
            echo "<h4 align='center'>Error Changing Password. Please Try Again.</h4>";
        }
    } else {
        echo "<h4 align='center'>Password Not Changed! <br>Please enter the same password in Password and Confirm Password Section</h4>";
    }
}
?>
