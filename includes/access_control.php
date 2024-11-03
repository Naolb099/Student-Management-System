<?php
session_start();

function checkAccess($requiredRole)
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
        header("Location: forbidden.php");
        exit();
    }
}
