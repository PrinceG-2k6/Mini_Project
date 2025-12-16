<?php
session_start();
include 'db_config.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

try{
  if ($result->num_rows === 1) 
{
  $user = $result->fetch_assoc();
  if (($password==$user['password'])) 
  {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['name']=$user['name'];
    
    if ($user['role'] === 'admin') {
      header("Location: /Code/ExamPlan/admin/index.php");
    } else {
      header("Location: student_dashboard.php");
    }
    exit();
  } 
  else 
  {
    echo "<script>
        alert('Invalid Password');
        </script>";
  }
} else {
  echo "<script>
        alert('User Not Found');
        </script>";
}

}
catch(PDOException $e) {
  echo "<h4 align='center'>An error occurred: " . $e->getMessage() . "</h4>";
}
?>
