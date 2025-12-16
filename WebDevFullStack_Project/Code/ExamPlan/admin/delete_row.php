<?PHP
include "db_config.php";

if(isset($_POST['delete']))
   {
        $subject  =$_POST['delete'];
        $students  = $conn->prepare("delete from exam_timetable where subject = '$subject'");

        if($students->execute())
        {   
            
            header("Location: view_timetable.php");
        }
        else{
            echo "Operation Failed";
        }
    }   
else{
    header("Location: view_timetable.php");
}

?>
