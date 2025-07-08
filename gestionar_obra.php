<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['obra_id'], $_POST['accion'])) {
    $obra_id = intval($_POST['obra_id']);
    $accion = $_POST['accion'];

    if ($accion === 'modificar') {
        header("Location: modificar_obra.php?obra_id=$obra_id");
        exit;
    } elseif ($accion === 'eliminar') {
        // Redireccionar a eliminar con método POST vía redirección intermedia
        echo "<form id='eliminarForm' action='eliminar_obra.php' method='POST'>
                <input type='hidden' name='obra_id' value='$obra_id'>
              </form>
              <script>document.getElementById('eliminarForm').submit();</script>";
        exit;
    }
}

header('Location: profile.php');
exit;
