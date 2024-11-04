<?php
session_start();
require 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['student_name'];
    $dob = $_POST['dob'];
    $disability = $_POST['disability'];
    $eligibility = $_POST['eligibility'];
    $coordinatorId = $_SESSION['user_id'];
    $filePath = '';

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["attachment"]["name"]);
        $targetFilePath = $targetDir . uniqid() . "_" . $fileName;

        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if ($fileType == "pdf") {
            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
                $filePath = $targetFilePath;
            } else {
                echo "<div class='alert alert-danger'>File upload failed.</div>";
                exit();
            }
        } else {
            echo "<div class='alert alert-danger'>Only PDF files are allowed.</div>";
            exit();
        }
    }

    try {
        $sql = "INSERT INTO eligibility (student_name, dob, disability, eligibility_status, coordinator_id, attachment) 
                VALUES (:student_name, :dob, :disability, :eligibility, :coordinator_id, :attachment)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_name', $studentName);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':disability', $disability);
        $stmt->bindParam(':eligibility', $eligibility);
        $stmt->bindParam(':coordinator_id', $coordinatorId);
        $stmt->bindParam(':attachment', $filePath);
        $stmt->execute();

        echo "<div class='alert alert-success'>Eligibility record saved successfully!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eligibility Determination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2>Eligibility Determination</h2>
        <form action="eligibility_form.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="disability" class="form-label">Disability</label>
                <input type="text" class="form-control" id="disability" name="disability" required>
            </div>
            <div class="mb-3">
                <label for="eligibility" class="form-label">Eligibility Status</label>
                <select class="form-select" id="eligibility" name="eligibility" required>
                    <option value="">Select</option>
                    <option value="eligible">Eligible</option>
                    <option value="not_eligible">Not Eligible</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Upload Document</label>
                <input type="file" class="form-control" id="attachment" name="attachment" accept="application/pdf">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>