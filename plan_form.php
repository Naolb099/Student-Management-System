<?php
require 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['student_name'];
    $accommodations = $_POST['accommodations'];
    $planDuration = $_POST['plan_duration'];

    try {
        $sql = "INSERT INTO plans (student_name, accommodations, plan_duration) 
                VALUES (:student_name, :accommodations, :plan_duration)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_name', $studentName);
        $stmt->bindParam(':accommodations', $accommodations);
        $stmt->bindParam(':plan_duration', $planDuration);
        $stmt->execute();

        echo "<div class='alert alert-success'>504 Plan saved successfully!</div>";
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
    <title>504 Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2>504 Plan</h2>
        <form action="plan_form.php" method="post">
            <div class="mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" required>
            </div>
            <div class="mb-3">
                <label for="accommodations" class="form-label">Accommodations</label>
                <textarea class="form-control" id="accommodations" name="accommodations" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="plan_duration" class="form-label">Plan Duration</label>
                <select class="form-select" id="plan_duration" name="plan_duration" required>
                    <option value="">Select Duration</option>
                    <option value="1_year">1 Year</option>
                    <option value="2_years">2 Years</option>
                    <option value="indefinite">Indefinite</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>