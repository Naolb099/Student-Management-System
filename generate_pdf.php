<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'includes/db_connection.php';
require 'includes/fpdf.php';


class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Eligibility Form', 0, 1, 'C');
        $this->Ln(10);
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM eligibility WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $form = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($form) {
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);

            $pdf->Cell(40, 10, 'Student Name: ' . $form['student_name']);
            $pdf->Ln(10);
            $pdf->Cell(40, 10, 'DOB: ' . $form['dob']);
            $pdf->Ln(10);
            $pdf->Cell(40, 10, 'Disability: ' . $form['disability']);
            $pdf->Ln(10);
            $pdf->Cell(40, 10, 'Eligibility Status: ' . $form['eligibility_status']);
            $pdf->Ln(10);

            $pdf->Output();
        } else {
            echo "No form found with that ID.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No form ID specified.";
}
?>