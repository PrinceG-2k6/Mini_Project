<?PHP
include "db_config.php";

if(isset($_POST['delete']))
   {
        $id  =$_POST['delete'];
        $students  = $conn->prepare("delete from users where id = '$id'");

        if($students->execute())
        {
            header("Location: manage_users.php");
        }
        else{
            echo "Operation Failed";
        }
    }   
else{
    header("Location: manage_users.php");
}

?>
