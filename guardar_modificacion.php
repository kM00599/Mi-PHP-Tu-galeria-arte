<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obra_id = intval($_POST['obra_id']);
    $titulo = $_POST['titulo'];
    $estilo = $_POST['estilo'];
    $emocion = $_POST['emocion'];
    $descripcion = $_POST['descripcion'];
    $user_id = $_SESSION['user_id'];
    $nueva_imagen_url = null;

    // Verificar que la obra pertenece al usuario
    $stmt_check = $conn->prepare("SELECT * FROM tu_arte WHERE id = ? AND user_id = ?");
    $stmt_check->bind_param("ii", $obra_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows === 0) {
        echo "Obra no encontrada o no autorizada.";
        exit;
    }

    // Procesar imagen si se subió una nueva
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES['imagen']['name']);
        $ruta_subida = 'uploads/' . $nombre_archivo;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_subida)) {
            $nueva_imagen_url = $ruta_subida;
        }
    }

    // Actualizar datos
    if ($nueva_imagen_url) {
        $stmt_update = $conn->prepare("UPDATE tu_arte SET titulo = ?, estilo = ?, emocion = ?, descripcion = ?, imagen_url = ? WHERE id = ?");
        $stmt_update->bind_param("sssssi", $titulo, $estilo, $emocion, $descripcion, $nueva_imagen_url, $obra_id);
    } else {
        $stmt_update = $conn->prepare("UPDATE tu_arte SET titulo = ?, estilo = ?, emocion = ?, descripcion = ? WHERE id = ?");
        $stmt_update->bind_param("ssssi", $titulo, $estilo, $emocion, $descripcion, $obra_id);
    }

    if ($stmt_update->execute()) {
        header("Location: profile.php");
        exit;
    } else {
        echo "Error al actualizar la obra.";
    }
}
?>
