<?PHP
include "db_config.php";

if(isset($_POST['delete']))
   {
        $room_no  =$_POST['delete'];
        $students  = $conn->prepare("delete from rooms where room_no = '$room_no'");

        if($students->execute())
        {
            header("Location: manage_room.php");
        }
        else{
            echo "Operation Failed";
        }
    }   
else{
    header("Location: manage_room.php");
}

?>
