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
        <div class="logout">
            <a href="/Code/ExamPlan/authentication/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
        <div class="Goback">
            <a href="/Code/ExamPlan/admin/Create_Room.php">
                <i class="fa-solid fa-right-from-bracket"></i> Go Back
            </a>
        </div>
    </div>

    <div class="manage_user">
        <i class="fas fa-users-cog"></i>
        <h1>Manage Room</h1>

        <div class="search">
            <form action="" method="POST">
                <input type="text" name="search" placeholder="Enter Room no for search">
                <br><br>
                <button>Search</button>
            </form>

            <?php
            include("db_config.php");

            if (isset($_POST['search'])) {
                $i = 1;
                $search = $_POST['search'];

                // Fetch rooms
                $rooms = $conn->prepare("SELECT * FROM rooms WHERE room_no LIKE ?");
                $rooms->execute(["%$search%"]);
                $result = $rooms->fetchAll();

                if (!empty($result)) {
                    echo "<h1>Searched Result :</h1>";
                    echo "<table border='1' cellspacing='0'>";
                    echo "<tr>
                            <th>Sr.no</th>
                    <th>Room No</th>
                            <th>Rows</th>
                            <th>Columns</th>
                            <th>Total Bench</th>
                            <th>Author</th>
                            <th>Delete</th>
                            <th>Update</th>
                          </tr>";

                    foreach ($result as $room) {
                        echo "<tr>
                                <td>$i</td>
                                <td>{$room['room_no']}</td>
                                <td>{$room['num_rows']}</td>
                                <td>{$room['columns']}</td>
                                <td>{$room['total_benches']}</td>
                                <td>{$room['auth_id']}</td>
                                <td>
                                    <form method='POST' class='delete' action='delete_room.php'>
                                        <button name='delete'  value='{$room['room_no']}'>Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href='update_room.php?id={$room['room_no']}'>Edit</a>
                                </td>
                              </tr>";
                        $i++;
                    }
                    echo "</table><br><br>";
                } else {
                    echo "<p>No rooms found matching the search criteria.</p>";
                }
            }
            ?>
        </div>

        <div class="All_room_data">
            <?php
            $i = 1;
            $rooms = $conn->prepare("SELECT * FROM rooms");
            $rooms->execute();
            $result = $rooms->fetchAll();

            echo "<h1>All rooms Data :</h1>";
            echo "<table border='1' cellspacing='0'>";
            echo "<tr>
            <th>Sr.no</th>
                    <th>Room No</th>
                            <th>Rows</th>
                            <th>Columns</th>
                            <th>Total Bench</th>
                            <th>Author</th>
                            <th>Delete</th>
                            <th>Update</th>
                    </tr>";

            foreach ($result as $room) {
                echo "<tr>
                                <td>$i</td>
                                <td>{$room['room_no']}</td>
                                <td>{$room['num_rows']}</td>
                                <td>{$room['columns']}</td>
                                <td>{$room['total_benches']}</td>
                                <td>{$room['auth_id']}</td>
                                <td>
                                    <form method='POST' class='delete' action='delete_room.php'>
                                        <button name='delete'  value='{$room['room_no']}'>Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href='update_room.php?id={$room['room_no']}'>Edit</a>
                                </td>
                              </tr>";
                        $i++;
            }
            echo "</table><br><br>";
            ?>
        </div>
        </div>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
            document.addEventListener("DOMContentLoaded", () => {
        // Confirm before deleting a room
        document.querySelectorAll(".delete button").forEach(button => {
            button.addEventListener("click", (event) => {
                const roomNo = event.target.value;
                const confirmDelete = confirm(`Are you sure you want to delete Room No: ${roomNo}?`);
                if (!confirmDelete) {
                    event.preventDefault();
                }
            });
        });

        // Highlight table rows on hover
        document.querySelectorAll("table tr").forEach(row => {
            row.addEventListener("mouseover", () => {
                row.style.backgroundColor = "#f0f0f0";
            });
            row.addEventListener("mouseout", () => {
                row.style.backgroundColor = "";
            });
        });

        // Validate search input
        const searchForm = document.querySelector(".search form");
        searchForm.addEventListener("submit", (event) => {
            const searchInput = searchForm.querySelector("input[name='search']");
            if (searchInput.value.trim() === "") {
                alert("Please enter a room number to search.");
                event.preventDefault();
            }
        });
    });

    </script>
</body>
</html>
