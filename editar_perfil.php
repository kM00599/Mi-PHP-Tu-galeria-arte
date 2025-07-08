<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$mensaje = "";

// Obtener datos actuales
$sql = "SELECT username, imagen_perfil FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Procesar formulario si se envió
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');

    if ($username === '') {
        $mensaje = "⚠️ Nombre de usuario requerido.";
    } else {
        // Procesar imagen si se sube
        if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] === 0) {
            $imagen_nombre = basename($_FILES["nueva_foto"]["name"]);
            $imagen_tmp = $_FILES["nueva_foto"]["tmp_name"];
            $ruta_guardado = "uploads/" . $imagen_nombre;

            if (!is_dir("uploads")) {
                mkdir("uploads", 0777, true);
            }

            if (move_uploaded_file($imagen_tmp, $ruta_guardado)) {
                $sql = "UPDATE users SET username = ?, imagen_perfil = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $username, $ruta_guardado, $user_id);
            }
        } else {
            $sql = "UPDATE users SET username = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $username, $user_id);
        }

        if ($stmt->execute()) {
            header("Location: profile.php");
            exit;
        } else {
            $mensaje = "❌ Error al actualizar el perfil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            padding: 50px;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        input, button {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
        }
        .mensaje {
            margin-top: 10px;
            color: red;
        }
        .perfil-foto {
            display: block;
            margin: auto;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Perfil</h2>
        <?php if ($usuario['imagen_perfil']): ?>
            <img src="<?= htmlspecialchars($usuario['imagen_perfil']) ?>" class="perfil-foto" alt="Perfil">
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Nombre de usuario:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($usuario['username']) ?>" required>

            <label>Nueva foto de perfil (opcional):</label>
            <input type="file" name="nueva_foto" accept="image/*">

            <button type="submit">Guardar cambios</button>
        </form>
        <?php if ($mensaje): ?>
            <div class="mensaje"><?= $mensaje ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
