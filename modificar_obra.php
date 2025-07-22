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
    $autor = $_POST['autor'];
    $fecha = $_POST['fecha'];

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
    $stmt = $conn->prepare("UPDATE tu_arte SET titulo = ?, estilo = ?, emocion = ?, descripcion = ?, autor = ?, fecha = ?,  imagen_url = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssssssii", $titulo, $estilo, $emocion, $descripcion, $autor,$fecha, $ruta, $obra_id, $user_id);
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
     :root {
      --gradient-1: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
      --gradient-2: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
      --gradient-3: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
      --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

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
  <form action="" method="POST" enctype="multipart/form-data">
    <h2>Editar Obra</h2>
    <input type="text" name="titulo" value="<?= htmlspecialchars($obra['titulo']) ?>" placeholder="Título de la obra"  required>

    <input type="text" name="autor" value="<?= htmlspecialchars($obra['autor']) ?>" placeholder="Autor de la obra" required>

    <input type="text" name="fecha" value="<?= htmlspecialchars($obra['fecha']) ?>"  placeholder="Fecha de creación" required>
    
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
        <option value="Pop Art ">Pop Art </option>
        <option value="Abstracto">Abstracto</option>
        <option value="fan art">fan art</option>"<?= htmlspecialchars($obra['estilo']) ?>" required>
        </select>

    <select name="emocion" required>
         <option value="">Selecciona una emoción</option>
        <option value="Alegría">Alegría</option>
        <option value="tristeza">Tristeza</option>
        <option value="ira">Ira</option>
        <option value="miedo">Miedo</option>
        <option value="Asco">Asco</option>
        <option value="Sopresa">Sopresa</option>
        <option value="Amor">Amor</option>
        <option value="Verguenza">Verguenza</option>
        <option value="Culpa">Culpa</option>
        <option value=""></option> "<?= htmlspecialchars($obra['emocion']) ?>" required>
       </select> 
    <textarea name="descripcion" rows="4" required><?= htmlspecialchars($obra['descripcion']) ?></textarea>

    <label>Imagen actual:</label><br>

    <img src="<?= htmlspecialchars($obra['imagen_url']) ?>" alt="Obra" style="width: 100px; height: auto;"><br><br>

    <label for="archivo" class="boton-personalizado">Subir nueva imagen (opcional):</label>
            <input type="file" id="archivo" name="nueva_foto" accept="image/*" class="hidden-input">

    <button type="submit">Guardar cambios</button>
  </form>
</body>
</html>

