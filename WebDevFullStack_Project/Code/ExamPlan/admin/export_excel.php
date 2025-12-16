
<?php
include 'db_config.php';


    $room_no = $_POST['room_no'];
    $exam_date = $_POST['exam_date'];
    $shift = $_POST['shift'];

    $stmt0 = $conn->prepare("SELECT * FROM rooms WHERE room_no = '$room_no'");
    $stmt0->execute();
    $results0 = $stmt0->fetchAll();
    $num_rows = $results0[0]['num_rows'];
    $columns = $results0[0]['columns'];

    $query = "
        SELECT * FROM seating_plans_left 
        WHERE room_no = :room_no AND exam_date = :exam_date AND shift = :shift";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':room_no' => $room_no,
        ':exam_date' => $exam_date,
        ':shift' => $shift,
    ]);

    $results = $stmt->fetchAll();

    $query2 = "
        SELECT * FROM seating_plans_right 
        WHERE room_no = :room_no AND exam_date = :exam_date AND shift = :shift";

    $stmt2 = $conn->prepare($query2);
    $stmt2->execute([
        ':room_no' => $room_no,
        ':exam_date' => $exam_date,
        ':shift' => $shift,
    ]);

    $results2 = $stmt2->fetchAll();
// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Seating_Plan_".$exam_date."_".$room_no."_".$shift.".xls");
header("Pragma: no-cache");
header("Expires: 0");


echo "<table border='2' cellspacing='0' align='center'>";
// echo "<div align='center' style='background-color:white;height:48px;display: flex;align-items: center;justify-content: center;font-size:30px;font-weight: 700;width: 80%;border-radius: 20px;border:2px solid rgb(150, 148, 148);margin-left: 10%;margin-top: 20px;'>Whiteboard (Front of Room)</div><BR>";
echo "<caption>WHITEBOARD</caption><BR><BR>";
echo "<tr></tr>";echo "<tr></tr>";
echo "<tr>";
    for($j=0;$j<$columns;$j++)
    {   
        echo "<th>";
        echo "Bench No";
        echo "</th>";
        echo "<th>";
        echo "left";
        echo "</th>"; 
        echo "<th>";
        echo "right";
        echo "</th>"; 
        echo "<th>";
        echo "</th>"; 
    }
    echo "</tr>"; 
for($i=0;$i<$num_rows;$i++)
{   echo "<tr>";
    for($j=0;$j<$columns;$j++)
    {   
        $count = $i +($j* $num_rows);
        echo "<td>";
        echo isset($results[$count]['bench_no']) ? $results[$count]['bench_no'] : '';
        echo "</td>";
        echo "<td>";
        echo isset($results[$count]['left_roll_no']) ? $results[$count]['left_roll_no'] : '';
        echo "</td>"; 
        echo "<td>"; 
        echo isset($results2[$count]['right_roll_no']) ? $results2[$count]['right_roll_no'] : '';
        echo "</td>";
        echo "<td>";
        
        echo "</td>";  
    }
    echo "</tr>";                      
}
echo "</table>";
?>
