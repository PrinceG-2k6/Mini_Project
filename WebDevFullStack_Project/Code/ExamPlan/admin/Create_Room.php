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
        
        <div class="logout"><a href="/Code/ExamPlan/admin/manage_room.php"><i class="fa-solid fa-right-from-bracket"></i> Manage Room</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <div class="room">
    <form action="" method="POST">
        <h1><i class="fas fa-door-open"></i> Create Room</h1>
        <h4>Please Enter The Details Of the Room</h4>
        <br>
        <label for="room_no">Room No :</label>
        <input type="text" name="room_no" id="room_no" required><br><br>
        <label for="num_rows">No. of Rows :</label>
        <input type="number" name="num_rows" id="num_rows" required><br><br>
        <label for="columns">No. of Column :    </label>
        <input type="number" name="columns" id="columns" required><br><br>
        
        <button type="submit">CREATE</button>
    </form>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="logout"><a href="/Code/ExamPlan/admin/delete_room.php"><i class="fa-solid fa-right-from-bracket"></i> Manage Room</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector("form");
            const roomNoInput = document.getElementById("room_no");
            const rowsInput = document.getElementById("num_rows");
            const columnsInput = document.getElementById("columns");

            // Add real-time validation for Room No
            roomNoInput.addEventListener("input", () => {
                if (!/^[A-Za-z0-9]+$/.test(roomNoInput.value)) {
                    roomNoInput.setCustomValidity("Room No can only contain alphanumeric characters.");
                } else {
                    roomNoInput.setCustomValidity("");
                }
            });

            // Add real-time validation for Rows and Columns
            [rowsInput, columnsInput].forEach(input => {
                input.addEventListener("input", () => {
                    if (input.value <= 0) {
                        input.setCustomValidity("Value must be greater than 0.");
                    } else {
                        input.setCustomValidity("");
                    }
                });
            });

            // Add a confirmation dialog before form submission
            form.addEventListener("submit", (event) => {
                const confirmation = confirm("Are you sure you want to create this room?");
                if (!confirmation) {
                    event.preventDefault();
                }
            });

            // Add a reset button functionality
            const resetButton = document.createElement("button");
            resetButton.type = "button";
            resetButton.textContent = "RESET";
            resetButton.style.marginLeft = "10px";
            form.appendChild(resetButton);

            resetButton.addEventListener("click", () => {
                form.reset();
            });
        });

        
    </script>
</body>
</html>

<?php

include 'db_config.php';

if (isset($_POST['room_no'])) {
    $room_no = $_POST['room_no'];
    $rows = intval($_POST['num_rows']);
    $columns = intval($_POST['columns']);
    $total_benches = $rows * $columns;
    $auth_id = $_SESSION['user_id'];

    try {
        $stmt = $conn->prepare("INSERT INTO rooms (room_no, num_rows, columns, total_benches, auth_id) VALUES ('$room_no', '$rows', '$columns', '$total_benches', '$auth_id')");
        $stmt->execute();

        echo "<script>
        alert('Room Created');
        </script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry error code
            echo "<script>
            alert('Room Already Exists');
            </script>";
        } else {
            echo "<h4 align='center'>An error occurred: " . $e->getMessage() . "</h4>";
        }
    }
}


?>
