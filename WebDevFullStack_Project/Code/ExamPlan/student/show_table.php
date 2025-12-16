
<?php
include "db_config.php";
$branch = $_GET['branch'];
$semester = $_GET['semester'];
$Exam_date = $_GET['examdate'];
$shift = $_GET['shift'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="/Code/ExamPlan/admin/style.css">
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
        <div class="Goback"><a href="/Code/ExamPlan/student/view_timetable.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <div class="view_plan">
        <div class="show_plan">
            <?php
            include "db_config.php";

            $stmt6 = $conn->prepare("SELECT DISTINCT(room_no) FROM seating_plans_left WHERE Exam_date = :Exam_date AND shift = :shift AND branch = :branch AND semester = :semester");
            $stmt6->execute([
                ':Exam_date' => $Exam_date,
                ':shift' => $shift,
                ':branch' => $branch,
                ':semester' => $semester
            ]);
            $results6 = $stmt6->fetchAll();
            if(!$results6){
                $stmt6 = $conn->prepare("SELECT DISTINCT(room_no) FROM seating_plans_right WHERE Exam_date = :Exam_date AND shift = :shift AND branch = :branch AND semester = :semester");
                $stmt6->execute([
                    ':Exam_date' => $Exam_date,
                    ':shift' => $shift,
                    ':branch' => $branch,
                    ':semester' => $semester
                ]);
                $results6 = $stmt6->fetchAll();
            }

            if ($results6) {
                foreach ($results6 as $result6) {
                    $room_no = $result6['room_no'];

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
                        $query = "SELECT * FROM seating_plans_left WHERE room_no = :room_no AND Exam_date = :Exam_date AND shift = :shift";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([
                            ':room_no' => $room_no,
                            ':Exam_date' => $Exam_date,
                            ':shift' => $shift
                        ]);
                        $results = $stmt->fetchAll();

                        $query2 = "SELECT * FROM seating_plans_right WHERE room_no = :room_no AND Exam_date = :Exam_date AND shift = :shift";
                        $stmt2 = $conn->prepare($query2);
                        $stmt2->execute([
                            ':room_no' => $room_no,
                            ':Exam_date' => $Exam_date,
                            ':shift' => $shift
                        ]);
                        $results2 = $stmt2->fetchAll();

                        
                    } catch (PDOException $e) {
                        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }

                    try {
                        echo "<table border='2' cellspacing='0' align='center'>";
                        echo "<caption>WHITEBOARD $room_no</caption>";
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
                                $count = $i + ($j * $num_rows);
                                echo "<td>" . (isset($results[$count]['bench_no']) ? $results[$count]['bench_no'] : '') . "</td>";
                                echo "<td>" . (isset($results[$count]['left_roll_no']) ? $results[$count]['left_roll_no'] : '') . "</td>";
                                echo "<td>" . (isset($results2[$count]['right_roll_no']) ? $results2[$count]['right_roll_no'] : '') . "</td>";
                                echo "<td></td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    } catch (PDOException $e) {
                        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }

                    echo "<br><br>";
                }
            } else {
                echo "Seating Plan Is NOT Created Yet";
            }
            ?>
        </div>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/student/view_timetable.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
    
        const examDateInput = document.getElementById("Exam_date");
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
