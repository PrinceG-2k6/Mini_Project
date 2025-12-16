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
    <div class="view_plan">
        <div class="search_plan">
            <form action="" method="POST">
                <table>
                    <tr>
                        <td><label for="room_no">Room No:</label></td>
                        <td><input type="text" id="room_no" name="room_no" required></td>
                    </tr>
                    <tr>
                        <td><label for="exam_date">Exam Date:</label></td>
                        <td><input type="date" id="exam_date" name="exam_date" required></td>
                    </tr>
                    <tr>
                        <td><label for="shift">Shift:</label></td>
                        <td>
                            <select id="shift" name="shift" required>
                                <option value="morning">Morning</option>
                                <option value="evening">Evening</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div>
                    <button type="submit" name="view_plan" value="view_plan">View Plan</button>
                    <button type="submit" name="export_excel" value="export_excel" formaction="export_excel.php">Export as Excel</button>
                    <button type="submit" name="delete_plan" value="delete_plan">Delete Plan</button>
                </div>
            </form>
        </div>
        <div class="show_plan">
                <?php

            include "db_config.php";
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_plan'])) {
                $room_no = $_POST['room_no'];
                $exam_date = $_POST['exam_date'];
                $shift = $_POST['shift'];

                
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
                
                try {
                    

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
                    // echo $results2[10]['right_roll_no'];
                    // echo $results[10]['left_roll_no'];
                    if (!$results){
                        echo '<p>No records found for the given criteria.</p>';
                    }
                } catch (PDOException $e) {
                    echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }


                    
            }
            ?>
            
            
                <?PHP
                if(isset($_POST['view_plan']))
                {
                    try{
                        
                        echo "<table border='2' cellspacing='0' align='center'>";
                    // echo "<div align='center' style='background-color:white;height:48px;display: flex;align-items: center;justify-content: center;font-size:30px;font-weight: 700;width: 80%;border-radius: 20px;border:2px solid rgb(150, 148, 148);margin-left: 10%;margin-top: 20px;'>Whiteboard (Front of Room)</div><BR>";
                    echo "<caption>WHITEBOARD $room_no</caption>";
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
                    
                    } catch (PDOException $e) {
                        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                }
                ?>
            
        </div>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        
            // Add confirmation dialog for delete action
        const deleteButton = document.querySelector("button[name='delete_plan']");
        deleteButton.addEventListener("click", (event) => {
            const confirmDelete = confirm("Are you sure you want to delete this seating plan?");
            if (!confirmDelete) {
                event.preventDefault();
            }
        });


        // Add date validation
        const examDateInput = document.getElementById("exam_date");
        examDateInput.addEventListener("change", () => {
            const selectedDate = new Date(examDateInput.value);
            const today = new Date();
            if (selectedDate < today) {
                alert("The exam date cannot be in the past.");
                examDateInput.value = "";
            }
        });
    </script>
</body>
</html>
<?PHP
if(isset($_POST['delete_plan'])){
    $room_no = $_POST['room_no'];
    $exam_date = $_POST['exam_date'];
    $shift = $_POST['shift'];

    try {
        $query = "DELETE FROM seating_plans_left WHERE room_no = :room_no AND exam_date = :exam_date AND shift = :shift";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':room_no' => $room_no,
            ':exam_date' => $exam_date,
            ':shift' => $shift,
        ]);

        $query2 = "DELETE FROM seating_plans_right WHERE room_no = :room_no AND exam_date = :exam_date AND shift = :shift";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute([
            ':room_no' => $room_no,
            ':exam_date' => $exam_date,
            ':shift' => $shift,
        ]);

        echo "<script>
        alert('Seating Plan Deleted');
        </script>";
    } catch (PDOException $e) {
        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}
?>
