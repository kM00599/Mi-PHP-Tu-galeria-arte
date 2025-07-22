<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $obra_id = $_GET['id'];


    // Verificar que la obra pertenece al usuario
    $stmt_check = $conn->prepare("SELECT * FROM tu_arte WHERE id = ? AND user_id = ?");
    $stmt_check->bind_param("ii", $obra_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $stmt_delete = $conn->prepare("DELETE FROM tu_arte WHERE id = ?");
        $stmt_delete->bind_param("i", $obra_id);
        $stmt_delete->execute();
    }
}

header("Location: profile.php");
exit;
