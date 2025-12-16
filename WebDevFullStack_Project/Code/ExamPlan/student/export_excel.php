<?php
include 'db_config.php';

$roll_no = $_POST['roll_no'];
$exam_date = $_POST['exam_date'];
$shift = $_POST['shift'];

// Fetch seating plan details
$stmt0 = $conn->prepare("
    SELECT * FROM seating_plans_left 
    WHERE left_roll_no = :roll_no AND exam_date = :exam_date AND shift = :shift
");
$stmt0->execute([
    ':roll_no' => $roll_no,
    ':exam_date' => $exam_date,
    ':shift' => $shift
]);
$results0 = $stmt0->fetchAll();

if (!$results0) {
    $stmt0 = $conn->prepare("
        SELECT * FROM seating_plans_right 
        WHERE right_roll_no = :roll_no AND exam_date = :exam_date AND shift = :shift
    ");
    $stmt0->execute([
        ':roll_no' => $roll_no,
        ':exam_date' => $exam_date,
        ':shift' => $shift
    ]);
    $results0 = $stmt0->fetchAll();
}

if (count($results0) > 0) {
    $room_no = $results0[0]['room_no'];
    $stmt0 = $conn->prepare("SELECT * FROM rooms WHERE room_no = :room_no");
    $stmt0->execute([':room_no' => $room_no]);
    $results0 = $stmt0->fetchAll();

    if (count($results0) > 0) {
        $num_rows = $results0[0]['num_rows'];
        $columns = $results0[0]['columns'];
    } else {
        echo '<p>No room details found for the given room number.</p>';
        exit();
    }
} else {
    echo '<p>No seating plan found for the given criteria.</p>';
    exit();
}

// Fetch seating plans for left and right
$query = "
    SELECT * FROM seating_plans_left 
    WHERE room_no = :room_no AND exam_date = :exam_date AND shift = :shift
";
$stmt = $conn->prepare($query);
$stmt->execute([
    ':room_no' => $room_no,
    ':exam_date' => $exam_date,
    ':shift' => $shift,
]);
$results = $stmt->fetchAll();

$query2 = "
    SELECT * FROM seating_plans_right 
    WHERE room_no = :room_no AND exam_date = :exam_date AND shift = :shift
";
$stmt2 = $conn->prepare($query2);
$stmt2->execute([
    ':room_no' => $room_no,
    ':exam_date' => $exam_date,
    ':shift' => $shift,
]);
$results2 = $stmt2->fetchAll();

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Seating_Plan_{$exam_date}_{$room_no}_{$shift}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Generate Excel table
echo "<table border='2' cellspacing='0' align='center'>";
echo "<caption>WHITEBOARD</caption><br><br>";
echo "<tr>";
for ($j = 0; $j < $columns; $j++) {
    echo "<th>Bench No</th>";
    echo "<th>Left</th>";
    echo "<th>Right</th>";
    echo "<th></th>";
}
echo "</tr>";

for ($i = 0; $i < $num_rows; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $columns; $j++) {
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
