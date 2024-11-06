<?php
session_start();
require 'includes/db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Coordinator') {
    header("Location: forbidden.php");
    exit();
}

$coordinatorId = $_SESSION['user_id'];
try {
    $sql = "SELECT * FROM eligibility WHERE coordinator_id = :coordinatorId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':coordinatorId', $coordinatorId);
    $stmt->execute();
    $eligibilityForms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> (Coordinator)</h2>
            <a href="logout.php" class="btn btn-danger ms-auto">Logout</a>
        </div>


        <p class="text-muted">Manage your students' eligibility forms and 504 plans.</p>


        <div class="mb-4">
            <a href="eligibility_form.php" class="btn btn-primary">New Eligibility Form</a>
            <a href="plan_form.php" class="btn btn-secondary">New 504 Plan Form</a>
        </div>

        <h3>Your Submitted Forms</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>DOB</th>
                    <th>Disability</th>
                    <th>Eligibility Status</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eligibilityForms as $form): ?>
                    <tr>
                        <td><?= htmlspecialchars($form['student_name']); ?></td>
                        <td><?= htmlspecialchars($form['dob']); ?></td>
                        <td><?= htmlspecialchars($form['disability']); ?></td>
                        <td><?= htmlspecialchars($form['eligibility_status']); ?></td>
                        <td><?= htmlspecialchars($form['created_at']); ?></td>
                        <td>
                            <a href="view_form.php?id=<?= $form['id']; ?>" class="btn btn-sm btn-info">View</a>
                            <a href="edit_form.php?id=<?= $form['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>