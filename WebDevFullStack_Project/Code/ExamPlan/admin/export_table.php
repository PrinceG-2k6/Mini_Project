<?php
include "db_config.php";
if (isset($_POST['export_table'])) {
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    try {
        $sql = "SELECT * FROM exam_timetable WHERE branch = :branch AND semester = :semester ORDER BY Exam_date, start_time";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':branch', $branch, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
        $stmt->execute();

        // Set headers for Excel download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Time_Table{$branch}_{$semester}.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Generate Excel table

        if ($stmt->rowCount() > 0) {
            echo "<table border='1' cellspacing='0'>
                    <tr>
                        <th>Branch</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . (!empty($row['branch']) ? $row['branch'] : 'N/A') . "</td>
                        <td>" . (!empty($row['semester']) ? $row['semester'] : 'N/A') . "</td>
                        <td>" . (!empty($row['subject']) ? $row['subject'] : 'N/A') . "</td>
                        <td>" . (!empty($row['Exam_date']) ? $row['Exam_date'] : 'N/A') . "</td>
                        <td>" . (!empty($row['shift']) ? $row['shift'] : 'N/A') . "</td>
                        <td>" . (!empty($row['start_time']) ? $row['start_time'] : 'N/A') . "</td>
                        <td>" . (!empty($row['end_time']) ? $row['end_time'] : 'N/A') . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No timetable found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
