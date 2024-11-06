<?php
require 'includes/access_control.php';
require 'includes/db_connection.php';

checkAccess('Administrator');


try {
    $summarySql = "SELECT COUNT(*) AS active_plans FROM eligibility WHERE eligibility_status = 'eligible'";
    $summaryStmt = $conn->query($summarySql);
    $summaryData = $summaryStmt->fetch(PDO::FETCH_ASSOC);
    $activePlans = $summaryData['active_plans'];
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}


$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $sql = "SELECT * FROM eligibility";
    if ($searchTerm) {
        $sql .= " WHERE student_name LIKE :searchTerm";
    }

    $stmt = $conn->prepare($sql);

    if ($searchTerm) {
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    }

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
    <title>Administrator Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> (Admin)</h2>
            <a href="logout.php" class="btn btn-danger ms-auto">Logout</a>
        </div>


        <a href="export_csv.php" class="btn btn-primary mb-3">Export as CSV</a>
        <div class="alert alert-info">Number of active 504 plans: <?= $activePlans; ?></div>


        <form method="get" action="admin_records.php" class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search by student name"
                value="<?= htmlspecialchars($searchTerm); ?>">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>DOB</th>
                    <th>Disability</th>
                    <th>Eligibility Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
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
                        <td><a href="generate_pdf.php?id=<?= $form['id']; ?>" class="btn btn-sm btn-primary">Download
                                PDF</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>