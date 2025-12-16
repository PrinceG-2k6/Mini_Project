
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
    <title><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'admin'; ?> Dashboard</title>
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
            <a href="/Code/ExamPlan/admin/index.php">
                <i class="fa-solid fa-right-from-bracket"></i> Go Back
            </a>
        </div>
    </div>

    <div class="manage_user">
        <i class="fas fa-book"></i>
        <h1>Manage Subject</h1>

        <div class="search">
            <form action="" method="POST">
                <input type="text" name="branch" placeholder="Enter Branch for search" required>
                <br><br>
                <input type="text" name="semester" placeholder="Enter Semester for search" required>
                <br><br>
                <button name='search'>Search</button>
            </form>

            <?php
            include("db_config.php");

            if (isset($_POST['search'])) {
               
                $branch = $_POST['branch'];
                $semester = $_POST['semester'];
                
                $i = 1;
                $Branch = $conn->prepare("SELECT * FROM subjects WHERE branch ='$branch' AND semester ='$semester'");
                $Branch->execute();
                $result = $Branch->fetchAll();

                if (!empty($result)) {
                    echo "<h1>Searched Branch Data :</h1>";
                    echo "<table border='1' cellspacing='0'>";
                    echo "<tr>
                            <th>Sr.no.</th>
                            <th>Branch</th>
                            <th>Semester</th>
                            <th>Subject</th>
                            <th>Delete</th>
                          </tr>";

                    foreach ($result as $subject) {
                        echo "<tr>
                                <td>$i</td>
                                <td>{$subject['branch']}</td>
                                <td>{$subject['semester']}</td>
                                <td>{$subject['subject']}</td>
                                <td>
                                    <form method='POST' class='delete' action='delete_subject.php'>
                                        <button name='delete' class='delete' value='{$subject['subject']}'>Delete</button>
                                    </form>
                                </td>
                                
                              </tr>";
                        $i++;
                    }
                    echo "</table>";
                } else {
                    echo "<p>No Branch found matching the search criteria.</p>";
                }
            }
            ?>
        </div>


        <div class="All_subject_data">
            <?php
            $i = 1;
            $Branch = $conn->prepare("SELECT * FROM subjects");
            $Branch->execute();
            $result = $Branch->fetchAll();

            echo "<h1>All Branch Data :</h1>";
            echo "<table border='1' cellspacing='0'>";
            echo "<tr>
                    <th>Sr.no.</th>
                    <th>Branch</th>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>Delete</th>
                    
                  </tr>";

            foreach ($result as $subject) {
                echo "<tr>
                        <td>$i</td>
                        <td>{$subject['branch']}</td>
                        <td>{$subject['semester']}</td>
                        <td>{$subject['subject']}</td>
                        <td>
                            <form method='POST' class='delete' action='delete_subject.php'>
                                <button name='delete' class='delete' value='{$subject['subject']}'>Delete</button>
                            </form>
                        </td>
                      </tr>";
                $i++;
            }
            echo "</table>";
            ?>
        </div>
    </div>
    <div class="back">
        <div class="logout"><a href="/Code/ExamPlan/authentication/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
        <div class="Goback"><a href="/Code/ExamPlan/admin/index.php"><i class="fa-solid fa-right-from-bracket"></i> Go Back</a></div>
    </div>
    <script>
        // Add a confirmation dialog for delete actions
        const deleteButtons = document.querySelectorAll('.delete button');
        if (deleteButtons.length > 0) {
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    if (!confirm("Are you sure you want to delete this user?")) {
                        event.preventDefault();
                    }
                });
            });
        }

        // Highlight table rows on hover
        document.querySelectorAll('table tr').forEach(row => {
            row.addEventListener('mouseover', function () {
                this.style.backgroundColor = '#f2f2f2';
            });
            row.addEventListener('mouseout', function () {
                this.style.backgroundColor = '';
            });
        });

        // Add a loading spinner for search button
        const searchButton = document.querySelector('.search button');
        if (searchButton) {
            searchButton.addEventListener('click', function () {
                const spinner = document.createElement('i');
                spinner.className = 'fa fa-spinner fa-spin';
                this.textContent = ' Searching...';
                this.prepend(spinner);
            });
        }
    </script>
</body>
</html>
