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
    <div class="add_admin">
    <form action="" method="POST">
        <i class="fas fa-user-shield"></i>
        <h1>Add Admin</h1>
        <h4>Please Enter The Details Of the Admin</h4>
        <br>
        <table>
            <tr>
                <td><label for="admin_id">Admin ID :</label></td>
                <td> <input type="text" name="admin_id" id="admin_id" required></td>
            </tr>
            
            <tr>
                <td><label for="name">Name :</label>
                </td>
                <td><input type="text" name="name" id="name" required></td>
            </tr>
    
            <tr>
                <td><label for="email">Email :</label>
                </td>
                <td><input type="email" name="email" id="email" required></td>
            </tr>
            
            <tr>
                <td><label for="password">Password :</label>
                </td>
                <td><input type="text" name="password" id="password" required></td>
            </tr>
            
            <tr>
                <td><label for="Cpassword">Confirm Password :</label>
                </td>
                <td><input type="password" name="Cpassword" id="Cpassword" required></td>
            </tr>
            
        </table>

        <button type="submit">ADD ADMIN</button>
    </form>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const passwordField = document.getElementById("password");
            const confirmPasswordField = document.getElementById("Cpassword");
            const submitButton = document.querySelector("button[type='submit']");

            // Real-time password match validation
            confirmPasswordField.addEventListener("input", () => {
                if (passwordField.value !== confirmPasswordField.value) {
                    confirmPasswordField.setCustomValidity("Passwords do not match");
                    confirmPasswordField.style.borderColor = "red";
                } else {
                    confirmPasswordField.setCustomValidity("");
                    confirmPasswordField.style.borderColor = "green";
                }
            });

        
        });
    </script>

</body>
</html>

<?php
include 'db_config.php';

if(isset($_POST['name']))
{
if($_POST['password']==$_POST['Cpassword']){
$admin_id=$_POST['admin_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


$stmt = $conn->prepare("INSERT INTO users (id,name,email,password,role)VALUES ('$admin_id','$name','$email','$password','admin')");
if (!$stmt->execute()) {
    echo "<script>
    alert('Data Can't Be Added');
    </script>".$conn->error;
}
$stmt = $conn->prepare("INSERT INTO admin ( admin_id,name,email)VALUES ('$admin_id','$name','$email')");
if ($stmt->execute()) {
    echo "<script>
    alert('Admin Added');
    </script>";
  
} else {
    die("<script>
    alert('Data Can't Be Added');
    </script>".$conn->error);
}
Echo "<h4 align='center'>Data Added ! <br>You Can Continue</h4>";
}
else{
    Echo "<h4 align='center'>Data not Added ! <br>Please enter same password in Password and Confirm Password Section</h4>";
}
}



?>
