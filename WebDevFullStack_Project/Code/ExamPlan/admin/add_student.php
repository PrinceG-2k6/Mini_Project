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
    <div class="add_student">
    <form action="" method="POST">
        <i class="fas fa-user-graduate"></i>
        <h1>Add Student</h1>
        <h4>Please Enter The Details Of the Student</h4>
        <br>
        <table>
            <tr>
                <td><label for="user_id">User ID :</label></td>
                <td> <input type="text" placeholder="Enter User ID" name="user_id" id="user_id" required></td>
            </tr>
            
            <tr>
                <td><label for="name">Name :</label>
                </td>
                <td><input type="text" name="name" id="name" required></td>
            </tr>
            
            <tr>
                <td><label for="year">Year :</label>
                  </td>
                <td>
                    <select name="year" id="year">
                        <option value="First">1st</option>
                        <option value="Second">2nd</option>
                        <option value="Third">3rd</option>
                        <option value="Fourth">4th</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><label for="branch">Branch :</label>
               </td>
                <td> <input type="text" name="branch" id="branch" required></td>
            </tr>
            
            <tr>
                <td><label for="roll_no">Roll no :</label>
                </td>
                <td><input type="text" name="roll_no" id="roll_no" required></td>
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
                <td><input type="password" name="Cpassword" id="Cpassword" placeholder="Enter Password" required></td>
            </tr>
            
        </table>

        <button type="submit">ADD STUDENT</button>
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

            // Disable submit button initially
            submitButton.disabled = true;

            // Function to validate passwords
            const validatePasswords = () => {
                const password = passwordField.value;
                const confirmPassword = confirmPasswordField.value;

                if (password !== confirmPassword) {
                    confirmPasswordField.setCustomValidity("Passwords do not match");
                    confirmPasswordField.reportValidity();
                    submitButton.disabled = true;
                } else {
                    confirmPasswordField.setCustomValidity("");
                    submitButton.disabled = false;
                }
            };

            // Add event listeners for password validation
            passwordField.addEventListener("input", validatePasswords);
            confirmPasswordField.addEventListener("input", validatePasswords);

            // Add a tooltip for the password field
            passwordField.addEventListener("focus", () => {
                passwordField.setAttribute("title", "Password must be at least 8 characters long");
            });

            // Add real-time feedback for required fields
            const requiredFields = document.querySelectorAll("input[required]");
            requiredFields.forEach(field => {
                field.addEventListener("blur", () => {
                    if (!field.value.trim()) {
                        field.classList.add("error");
                        field.setAttribute("title", "This field is required");
                    } else {
                        field.classList.remove("error");
                        field.removeAttribute("title");
                    }
                });
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
$user_id=$_POST['user_id'];
$name = $_POST['name'];
$year =$_POST['year'];
$branch = $_POST['branch'];
$roll_no = $_POST['roll_no'];
$email = $_POST['email'];
$password = $_POST['password'];


$stmt = $conn->prepare("INSERT INTO users (id,name,email,password,role)VALUES ('$user_id','$name','$email','$password','student')");
if (!$stmt->execute()) {
    echo "<script>
    alert('Data Can't Be Added');
    </script>".$conn->error;
}
$stmt = $conn->prepare("INSERT INTO students ( user_id,name,roll_no, branch,year,email)VALUES ('$user_id','$name','$roll_no', '$branch','$year','$email')");
if ($stmt->execute()) {
    echo "<script>
    alert('Student Added');
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
