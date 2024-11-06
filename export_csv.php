<?php
session_start();
require 'includes/db_connection.php';
require 'includes/access_control.php';

checkAccess('Administrator');


header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=eligibility_forms.csv');

$output = fopen('php://output', 'w');

fputcsv($output, ['Student Name', 'DOB', 'Disability', 'Eligibility Status', 'Date Created', 'Attachment']);

try {
    $sql = "SELECT student_name, dob, disability, eligibility_status, created_at, attachment FROM eligibility";
    $stmt = $conn->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

fclose($output);
exit();
