<?php

include('conexion.php');

$emocion = isset($_GET['emocion']) ? $_GET['emocion'] : '';
$estilo = isset($_GET['estilo']) ? $_GET['estilo'] : '';

// Base SQL

$sql = "SELECT * FROM tu_arte WHERE 1=1";

if (!empty($_GET['emocion'])) {
    $sql .= " AND emocion = '" . $_GET['emocion'] . "'";
}
if (!empty($_GET['estilo'])) {
    $sql .= " AND estilo = '" . $_GET['estilo'] . "'";
}


if (!empty($_GET['q'])) {
    $sql .= " AND (titulo LIKE '%" . $_GET['q'] . "%' OR descripcion LIKE '%" . $_GET['q'] . "%')";
}


$sql .= " ORDER BY RAND()";

$stmt = $conn->prepare($sql);

// Asociar parámetros si hay filtros
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Explorar obras</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 30px;
      display: flex;
      justify-content: center;
    }

    .container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
      width: 100%;
      max-width: 1200px;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      text-decoration: none;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-8px);
    }

    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .card-content {
      padding: 15px;
    }

    .card-content h3 {
      margin: 0;}
  </style>
</head>
<body>

<div class="container">
  <?php while ($row = $resultado->fetch_assoc()): ?>
    <a href="#" class="card">
      <img src="<?= htmlspecialchars($row['imagen_url']) ?>" alt="<?= htmlspecialchars($row['titulo']) ?>">
      <div class="card-content">
        <h3><?= htmlspecialchars($row['titulo']) ?></h3>
        <p><?= htmlspecialchars($row['descripcion']) ?></p>
      </div>
    </a>
  <?php endwhile; ?>
</div>

</body>
</html>
