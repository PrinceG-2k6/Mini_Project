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
    <div class="generate_plan_container">
        <i class="fas fa-cogs"></i>
        <h1>Generate Plan</h1>
        <h4>Please Enter The Details Of Students To Be In Room</h4>
        <br>
        <form action="" method="POST">
            <div class="input-section">
                <div class="form-side">
                    <h3>Left Bench Students</h3>
                    <label>Branch:</label>
                    <input type="text" id="leftBranch" name="leftBranch" placeholder="e.g., CSH" >
                    <label>Semester:</label>
                    <input type="number" id="leftSemester" name="leftSemester" min="1" max="8" placeholder="e.g., 1" >
                    <label>From Roll No:</label>
                    <input type="text" id="leftFrom" name="leftFrom" placeholder="e.g., BT24CSH001">
                    <label>To Roll No:</label>
                    <input type="text" id="leftTo" name="leftTo" placeholder="e.g., BT24CSH042">
                </div>
                <div class="form-side">
                    <h3>Right Bench Students</h3>
                    <label>Branch:</label>
                    <input type="text" id="rightBranch" name="rightBranch" placeholder="e.g., CSE">
                    <label>Semester:</label>
                    <input type="number" name="rightSemester" id="rightSemester" min="1" max="8" placeholder="e.g., 1">
                    <label>From Roll No:</label>
                    <input type="text" id="rightFrom" name="rightFrom" placeholder="e.g., BT24CSE001">
                    <label>To Roll No:</label>
                    <input type="text" id="rightTo" name="rightTo" placeholder="e.g., BT24CSE042">
                </div>
            </div>
            <div class="room_input">
                <table>
                    <tr>
                        <td><label for="Exam_date">Exam Date:</label></td>
                        <td><input type="date" id="Exam_date" name="Exam_date"></td>
                    </tr>
                    <tr>
                        <td><label for="shift">Shift:</label></td>
                        <td>
                            <select id="shift" name="shift" required>
                                <option value="Morning">Morning</option>
                                <option value="Evening">Evening</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="room_no">Room No:</label></td>
                        <td><input type="text" id="room_no" name="room_no" maxlength="10" required></td>
                    </tr>
                </table>
                <div class="left_bench"></div>
                <div class="right_bench"></div>
                <button type="submit" name="gen_l">GENERATE LEFT</button>
                <button type="submit" name="gen_b">GENERATE BOTH</button>
                <button type="submit" name="gen_r">GENERATE RIGHT</button>
            </div>
        </form>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const leftBranchInput = document.getElementById("leftBranch");
            const rightBranchInput = document.getElementById("rightBranch");
            const leftSem = document.getElementById("leftSemester");
            const rightSem = document.getElementById("rightSemester");
            const leftFromInput = document.getElementById("leftFrom");
            const leftToInput = document.getElementById("leftTo");
            const rightFromInput = document.getElementById("rightFrom");
            const rightToInput = document.getElementById("rightTo");
            const roomNoInput = document.getElementById("room_no");
            const examDateInput = document.getElementById("Exam_date");
            const shiftSelect = document.getElementById("shift");

            // Add real-time validation for required fields
            const inputs = [leftBranchInput, rightBranchInput, leftFromInput, leftToInput, rightFromInput, rightToInput, roomNoInput, examDateInput,leftSem , rightSem];
            inputs.forEach(input => {
                input.addEventListener("input", () => {
                    if (input.value.trim() === "") {
                        input.style.borderColor = "red";
                    } else {
                        input.style.borderColor = "green";
                    }
                });
            });
            // Add a confirmation dialog before form submission
            const form = document.querySelector("form");
            form.addEventListener("submit", (event) => {
                const confirmation = confirm("Are you sure you want to generate the seating plan?");
                if (!confirmation) {
                    event.preventDefault();
                }
            });

            // Add a date picker restriction to prevent past dates
            const today = new Date().toISOString().split("T")[0];
            examDateInput.setAttribute("min", today);

            // Add dynamic feedback for room number input
            roomNoInput.addEventListener("input", () => {
                const feedback = document.createElement("div");
                feedback.id = "roomFeedback";
                feedback.style.color = "blue";
                feedback.style.marginTop = "5px";

                const existingFeedback = document.getElementById("roomFeedback");
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                if (roomNoInput.value.trim() !== "") {
                    feedback.textContent = `Room No: ${roomNoInput.value} is being processed...`;
                    roomNoInput.parentNode.appendChild(feedback);
                }
            });
        });
    </script>
</body>
</html>

<?php
include 'db_config.php'; 

if (isset($_POST['room_no'])) {
    $room_no = $_POST['room_no'];
    $shift = $_POST['shift'];
    $Exam_date = $_POST['Exam_date'];

    function generateRange($from, $to) {
        $list = [];
        $prefix = preg_replace('/\d+$/', '', $from);
        $start = intval(substr($from, -3));
        $end = intval(substr($to, -3));
        for ($i = $start; $i <= $end; $i++) {
            $list[] = $prefix . str_pad($i, 3, "0", STR_PAD_LEFT);
        }
        return $list;
    }

    $stmt = $conn->prepare("SELECT num_rows, columns, total_benches FROM rooms WHERE room_no = :room_no");
    $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
    $stmt->execute();
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        die("Room not found");
    }

    $maxBenches = $room['total_benches'];

    if (isset($_POST['gen_l']) || isset($_POST['gen_b'])) {
        $leftBranch = $_POST['leftBranch'];
        $leftFrom = $_POST['leftFrom'];
        $leftTo = $_POST['leftTo'];
        $leftSemester = $_POST['leftSemester'];

        $leftList = generateRange($leftFrom, $leftTo);
        $x = 0;

        $stmt = $conn->prepare("SELECT left_roll_no FROM seating_plans_left WHERE room_no = '$room_no' AND Exam_date = '$Exam_date' AND shift = '$shift' AND semester = '$leftSemester'");
        $stmt->execute();
        $leftStudents = $stmt->fetchAll();

        foreach ($leftStudents as $leftStudent) {
            $x++;
        }

        if (($x + count($leftList)) > $maxBenches) {
            die("Room Cannot Accommodate That Many Students for the left side on the bench");
        }

        $stmt = $conn->prepare("INSERT INTO seating_plans_left (Exam_date, shift,branch ,semester, room_no, bench_no, left_roll_no)
                                VALUES (:Exam_date, :shift,:branch , :semester, :room_no, :bench_no, :left_roll_no)");

        for ($i = 0; $i < count($leftList); $i++) {
            $left = $leftList[$i] ?? null;
            $x++;
            $benchNo = $x;
            $stmt->bindParam(':Exam_date', $Exam_date, PDO::PARAM_STR);
            $stmt->bindParam(':shift', $shift, PDO::PARAM_STR);
            $stmt->bindParam(':branch', $leftBranch, PDO::PARAM_STR);
            $stmt->bindParam(':semester', $leftSemester, PDO::PARAM_INT);
            $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
            $stmt->bindParam(':bench_no', $benchNo, PDO::PARAM_INT);
            $stmt->bindParam(':left_roll_no', $left, PDO::PARAM_STR);
            $stmt->execute();
            
        }
        
        
    }

    if (isset($_POST['gen_r']) || isset($_POST['gen_b']))
    {
        $rightBranch = $_POST['rightBranch'];
        $rightFrom = $_POST['rightFrom'];
        $rightTo = $_POST['rightTo'];
        $rightSemester =$_POST['rightSemester'];

        $rightList = generateRange($rightFrom, $rightTo);
        $y = 0;

        $stmt = $conn->prepare("SELECT right_roll_no FROM seating_plans_right WHERE room_no = :room_no  AND Exam_date = '$Exam_date' AND shift = '$shift' AND semester='$rightSemester' ");
        $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
        $stmt->execute();
        $rightStudents = $stmt->fetchAll();

        foreach ($rightStudents as $rightStudent) {
            if ($rightStudent != null) {
                $y++;   
            }
        }

        if (($y + count($rightList)) > $maxBenches) {
            die("Room Cannot Accommodate That Many Students for the right side on the bench");
        }

        $stmt = $conn->prepare("INSERT INTO seating_plans_right (Exam_date, shift,branch ,semester, room_no, bench_no, right_roll_no)
                                VALUES (:Exam_date, :shift,:branch , :semester, :room_no, :bench_no, :right_roll_no)");

        for ($i = 0; $i < count($rightList); $i++) {
            $right = $rightList[$i] ?? null;
            $y++;
            $benchNo = $y;
            $stmt->bindParam(':Exam_date', $Exam_date, PDO::PARAM_STR);
            $stmt->bindParam(':shift', $shift, PDO::PARAM_STR);
            $stmt->bindParam(':branch', $rightBranch, PDO::PARAM_STR);
            $stmt->bindParam(':semester', $rightSemester, PDO::PARAM_INT);
            $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
            $stmt->bindParam(':bench_no', $benchNo, PDO::PARAM_INT);
            $stmt->bindParam(':right_roll_no', $right, PDO::PARAM_STR);
            $stmt->execute();
            
        }
    }

        

    echo "<script>
        alert('Data Inserted in Seating Plan ');
        </script>";
}
?>
