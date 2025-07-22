<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
$emocion = $_POST['emocion'];
$estilo = $_POST['estilo'];
$descripcion = $_POST['descripcion'];
$autor = $_POST['autor'];
$fecha = $_POST['fecha'];
$user_id = $_SESSION['user_id'];

    // Manejo de imagen
    $imagen = $_FILES['imagen'];
    $imagen_nombre = uniqid() . "_" . basename($imagen["name"]);
    $ruta_destino = "uploads/" . $imagen_nombre;

    if (move_uploaded_file($imagen["tmp_name"], $ruta_destino)) {
        // Guardar en la base de datos
       $stmt = $conn->prepare("INSERT INTO tu_arte (titulo, emocion, estilo, descripcion, imagen_url, autor,fecha, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $titulo, $emocion, $estilo, $descripcion, $ruta_destino, $autor, $fecha, $user_id);


        if ($stmt->execute()) {
            echo "Obra subida correctamente. <a href='profile.php'>Ver mi perfil</a>";
        } else {
            echo "Error al guardar: " . $stmt->error;
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Subir Obra</title>
  <style>
    :root {
      --gradient-1: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
      --gradient-2: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
      --gradient-3: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
      --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fafafa;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
    }

    form {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }

    form input[type="text"],
    form input[type="file"],
    form textarea,
    form select {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
    }

    form textarea {
      resize: vertical;
      min-height: 80px;
    }
    
    form button {
      background: var(--gradient-3);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
      width: 100%;
    }

    form button:hover {
      background: var(--gradient-2);
    }

    .hidden-input {
      display: none;
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



  </style>
</head>

<script>
  function mostrarVistaPrevia(event) {
    const input = event.target;
    const imagen = document.getElementById('vistaPrevia');

    if (input.files && input.files[0]) {
      const lector = new FileReader();
      lector.onload = function(e) {
        imagen.src = e.target.result;
        imagen.style.display = 'block';
      }
      lector.readAsDataURL(input.files[0]);
    } else {
      imagen.src = "#";
      imagen.style.display = 'none';
    }
  }
</script>

<body>

  <form action="subir_obra.php" method="POST" enctype="multipart/form-data">
  <h2 style="text-align: center; margin-bottom: 20px;">Subir nueva obra</h2>

  <input type="text" name="titulo" placeholder="Título de la obra" required>
  <input type="text" name="autor" placeholder="Nombre del autor" required>

  <input type="text" name="Fecha de creación" id="fecha"  placeholder="Fecha de creación" required>

  <textarea name="descripcion" placeholder="Descripción de la obra" required></textarea>
  
  <label for="archivo" class="boton-personalizado">Selecciona una imagen</label>
<input type="file" id="archivo" name="imagen" accept="image/*" required onchange="mostrarVistaPrevia(event)" class="hidden-input">


  <img id="vistaPrevia" src="#" alt="Vista previa" style="display: none; max-width: 100%; margin-top: 10px; border-radius: 8px;">


  <select name="emocion" required>
    <option value="">Selecciona una emoción</option>
    <option value="Alegría">Alegría</option>
    <option value="tristeza">Tristeza</option>
    <option value="ira">Ira</option>
    <option value="miedo">Miedo</option>
    <option value="Asco">Asco</option>
    <option value="Sorpresa">Sorpresa</option>
    <option value="Amor">Amor</option>
    <option value="Verguenza">Verguenza</option>
    <option value="Culpa">Culpa</option>
  </select><br>

  <select name="estilo" required>
    <option value="">Selecciona un estilo</option>
    <option value="Realismo">Realismo</option>
    <option value="Impresionismo">Impresionismo</option>
    <option value="Expresionismo">Expresionismo</option>
    <option value="Cubismo">Cubismo</option>
    <option value="Surrealismo">Surrealismo</option>
    <option value="Barroco">Barroco</option>
    <option value="Futurismo">Futurismo</option>
    <option value="Arte Naíf">Arte Naíf</option>
    <option value="Pop Art">Pop Art</option>
    <option value="Abstracto">Abstracto</option>
    <option value="fan art">fan art</option>
  </select><br>

  <button type="submit">Subir obra</button>
</form>

</body>
</html>
