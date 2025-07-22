<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('conexion.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Actualizar imagen de perfil si se envía una nueva
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["nueva_foto"])) {
    $imagen_nombre = $_FILES["nueva_foto"]["name"];
    $imagen_tmp = $_FILES["nueva_foto"]["tmp_name"];
    $ruta_guardado = "uploads/" . basename($imagen_nombre);

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (move_uploaded_file($imagen_tmp, $ruta_guardado)) {
        $sql_update = "UPDATE users SET imagen_perfil = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $ruta_guardado, $user_id);
        $stmt_update->execute();
    }
}

// Obtener datos del usuario
$sql_usuario = "SELECT username, imagen_perfil FROM users WHERE id = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $user_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();
$usuario = $resultado_usuario->fetch_assoc();

// Obtener obras del usuario
 $sql_obras = "SELECT * FROM tu_arte WHERE user_id = ?";
$stmt_obras = $conn->prepare($sql_obras);
$stmt_obras->bind_param("i", $user_id);
$stmt_obras->execute();
$resultado_obras = $stmt_obras->get_result();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <style>
    :root {
      --gradient-1: linear-gradient(135deg, #574759 0%, #40122c 100%);
      --gradient-2: linear-gradient(135deg, #3e1c33 0%, #87586c 100%);
     
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
        padding: 0;
    }

    .blocks {
      display: flex;
      gap: 15px;
      margin-bottom: 40px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .block {
      padding: 15px 15px;
      border-radius: 12px;
      color: white;
      text-decoration: none;
      font-weight: bold;
      background: var(--bg);
      transition: transform 0.3s ease;
    }

    .block:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    form {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      width: 90%;
      max-width: 400px;
      align-items: center;
    }

    form input {
      width: 100%;
      padding: 12px 16px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
    }

    form button {
      padding: 12px 20px;
      background: var(--gradient-3);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      width: 100%;
    }

    form button:hover {
      background: var(--gradient-2);
    }

    .obras-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
  width: 100%;
  max-width: 1000px;
  margin: 20px auto;
}

.obra-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease;
}

.obra-card:hover {
  transform: scale(1.05);
}

.obra-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.obra-info {
  padding: 12px;
  text-align: center;
}

.obra-info h4 {
  margin: 5px 0;
  font-size: 16px;
  color: #333;
}

.obra-info p {
  margin: 0;
  font-size: 13px;
  color: #777;
}

.obra-actions {
  margin-top: 10px;
  display: flex;
  justify-content: center;
  gap: 12px;
}

.btn {
  padding: 6px 10px;
  font-size: 14px;
  text-decoration: none;
  border-radius: 6px;
  color: white;
}

.btn.editar {
  background-color: #5c6bc0;
}

.btn.eliminar {
  background-color: #e53935;
}

.contenedor {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* altura de pantalla completa */
  }

  .perfil {
    width: 100px;
    height: 100px;
    border-radius: 70%;
  }

  .perfil-principal {
  text-align: center;
  margin-top: 40px;
  position: relative;
}

.perfil-foto-nombre {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

.imagen-perfil {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #ddd;
}

.btn-editar {
  position: absolute;
  top: 10px;
  right: -120px;
  background-color: #ddd;
  padding: 8px 14px;
  border-radius: 12px;
  text-decoration: none;
  color: #333;
  font-size: 14px;
  transition: all 0.3s ease;
}

.btn-editar:hover {
  background-color: #ccc;
}

@media (max-width: 600px) {
  .perfil-principal {
    margin-top: 20px;
    padding: 0 10px;
  }






  </style>
</head>
<body>

  

  

</body>
</html>

</head>
<body>
<div class="perfil-principal">
  <div class="perfil-foto-nombre">
    <img src="<?= $usuario['imagen_perfil'] ?: 'default.png' ?>" alt="Perfil" class="imagen-perfil">
    <h2><?= htmlspecialchars($usuario['username']) ?></h2>
  </div>

  <a href="editar_perfil.php" class="btn-editar">Editar perfil</a>

  <div class="blocks">
    <a href="subir_obra.php" class="block" style="--bg: var(--gradient-1);">subir Obra</a>
    <a href="index.php" class="block" style="--bg: var(--gradient-1);">Inicio</a>
    <a href="logout.php" class="block" style="--bg: var(--gradient-1);">cerrar sesión</a>
  </div>
</div>

    <h3>Mis Obras</h3>
<div class="obras-container">
  <?php
  $resultado_obras->data_seek(0);
  while($row = $resultado_obras->fetch_assoc()): ?>
    <div class="obra-card">
      <img src="<?= htmlspecialchars($row['imagen_url']) ?>" alt="Obra">
      <div class="obra-info">
        <h4><?= htmlspecialchars($row['titulo']) ?></h4>
        <p><?= htmlspecialchars($row['emocion']) ?> · <?= htmlspecialchars($row['estilo']) ?> </p> 
        <p><?= htmlspecialchars($row['descripcion']) ?></p>
        <p><?= htmlspecialchars($row['autor']) ?></p>
        <p><?= htmlspecialchars($row['fecha']) ?></p>
        

        <div class="obra-actions">
         <a href="modificar_obra.php?id=<?= $row['id'] ?>" class="block" style="--bg: var(--gradient-2);">Modificar obra</a>

          <a href="eliminar_obra.php?id=<?= $row['id'] ?>"class="block" style="--bg: var(--gradient-2);">Eliminar obra</a>

        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>


</body>
</html>

