<?PHP
include "db_config.php";

if(isset($_POST['delete']))
   {
        $subject  =$_POST['delete'];
        $stmt  = $conn->prepare("delete from subjects where subject = '$subject'");

        if($stmt->execute())
        {
            header("Location: manage_subject.php");
        }
        else{
            echo "Operation Failed";
        }
    }   
else{
    header("Location: manage_subject.php");
}

?>
