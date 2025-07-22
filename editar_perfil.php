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
    :root {
      --gradient-1: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
      --gradient-2: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
      --gradient-3: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
      --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
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

        .boton-personalizado {
  background: var(--gradient-1);
  color: white;
  padding: 12px;
  border-radius: 10px;
  font-size: 16px;
  cursor: pointer;
  display: inline-block;
  text-align: center;
  margin-bottom: 16px;
  width: 100%;
  text-decoration: none;
  border: none;
  transition: background 0.3s;
}

.boton-personalizado:hover {
  background: var(--gradient-2);
}
 .hidden-input {
  display: none;
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

           <label for="archivo" class="boton-personalizado">Nueva foto de perfil (opcional):</label>
            <input type="file" id="archivo" name="nueva_foto" accept="image/*" class="hidden-input">

            <button type="submit">Guardar cambios</button>
        </form>
        <?php if ($mensaje): ?>
            <div class="mensaje"><?= $mensaje ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
