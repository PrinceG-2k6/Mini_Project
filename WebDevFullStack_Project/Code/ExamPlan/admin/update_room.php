<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Code/ExamPlan/index.html");
    exit();
}
?>

<?php
include("db_config.php");

if (isset($_GET['id'])) {
    $room_no = $_GET['id'];
    $rooms = $conn->prepare("SELECT * FROM rooms WHERE room_no = '$room_no'");
    $rooms->execute();
    $room = $rooms->fetchAll();

    $num_rows = $room[0]['num_rows'];
    $columns = $room[0]['columns'];
    $total_benches = $room[0]['total_benches'];
    $auth_id = $room[0]['auth_id'];
    
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
    <div class="update">
            <form action="" method="POST">
                <label for="room_no">ROOM NO:</label>
                <input type="text" id="room_no" name="room_no" value="<?php echo $room_no; ?>" readonly>
                <br><br>
                
                <label for="num_rows">Rows:</label>
                <input type="number" id="num_rows" name="num_rows" value="<?php echo $num_rows; ?>">
                <br><br>

                <label for="columns">Columns:</label>
                <input type="number" id="columns" name="columns" value="<?php echo $columns; ?>">
                <br><br>
                
                <br><br>
                
                <button value="<?php echo $id; ?>" name="update">Update Data</button>
            </form>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/manage_room.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const numRowsInput = document.getElementById("num_rows");
            const columnsInput = document.getElementById("columns");

            const validateInput = (input) => {
                if (input.value < 1) {
                    input.value = 1;
                }
            };

            numRowsInput.addEventListener("input", () => validateInput(numRowsInput));
            columnsInput.addEventListener("input", () => validateInput(columnsInput));

            const form = document.querySelector("form");
            form.addEventListener("submit", (event) => {
                const numRows = parseInt(numRowsInput.value, 10);
                const columns = parseInt(columnsInput.value, 10);

                if (isNaN(numRows) || isNaN(columns) || numRows < 1 || columns < 1) {
                    event.preventDefault();
                    alert("Please enter valid positive numbers for rows and columns.");
                }
            });
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $num_rows = $_POST['num_rows'];
    $columns = $_POST['columns'];
    $total_benches = $_POST['num_rows'] * $_POST['columns'];
    
    $update = $conn->prepare("UPDATE rooms SET
        num_rows = '$num_rows',
        columns = '$columns',
        total_benches = '$total_benches'
        WHERE room_no = '$room_no'");

    if ($update->execute()) {
        header("Location: manage_room.php");
    } else {
        echo "Update Failed";
    }
}

?>
