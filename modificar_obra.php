<?php
session_start();
include('conexion.php');

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Verifica que se haya enviado un ID de obra
if (!isset($_GET['id'])) {
    echo "ID de obra no especificado.";
    exit;
}

$obra_id = intval($_GET['id']);

// Verifica que la obra pertenezca al usuario
$stmt = $conn->prepare("SELECT * FROM tu_arte WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $obra_id, $user_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    echo "Obra no encontrada o no tienes permiso para editarla.";
    exit;
}

$obra = $resultado->fetch_assoc();

// Procesar actualización si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $estilo = $_POST['estilo'];
    $emocion = $_POST['emocion'];
    $descripcion = $_POST['descripcion'];

    // Si se sube una nueva imagen
    if (!empty($_FILES['nueva_imagen']['name'])) {
        $nombre_imagen = $_FILES["nueva_imagen"]["name"];
        $tmp_imagen = $_FILES["nueva_imagen"]["tmp_name"];
        $ruta = "uploads/" . basename($nombre_imagen);
        move_uploaded_file($tmp_imagen, $ruta);
    } else {
        $ruta = $obra['imagen_url']; // se mantiene la anterior
    }

    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE tu_arte SET titulo = ?, estilo = ?, emocion = ?, descripcion = ?, imagen_url = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssssii", $titulo, $estilo, $emocion, $descripcion, $ruta, $obra_id, $user_id);
    $stmt->execute();

    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Obra</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 40px;
      display: flex;
      justify-content: center;
    }
    form {
      background: white;
      padding: 25px;
      border-radius: 10px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input, textarea, select {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      background: #5c6bc0;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      width: 100%;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <form action="" method="POST" enctype="multipart/form-data">
    <h2>Editar Obra</h2>
    <input type="text" name="titulo" value="<?= htmlspecialchars($obra['titulo']) ?>" required>
    <input type="text" name="estilo" value="<?= htmlspecialchars($obra['estilo']) ?>" required>
    <input type="text" name="emocion" value="<?= htmlspecialchars($obra['emocion']) ?>" required>
    <textarea name="descripcion" rows="4" required><?= htmlspecialchars($obra['descripcion']) ?></textarea>
    <label>Imagen actual:</label><br>
    <img src="<?= htmlspecialchars($obra['imagen_url']) ?>" alt="Obra" style="width: 100px; height: auto;"><br><br>
    <label>Subir nueva imagen (opcional):</label>
    <input type="file" name="nueva_imagen" accept="image/*">
    <button type="submit">Guardar cambios</button>
  </form>
</body>
</html>

