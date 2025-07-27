<?php
session_start();
include('conexion.php');

// Solo admins pueden acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Eliminar usuario
if (isset($_GET['eliminar_usuario'])) {
    $id = intval($_GET['eliminar_usuario']);
    // Prevenir eliminación del admin principal (ajusta tu ID)
    if ($id !== $_SESSION['user_id']) {
        $conn->query("DELETE FROM users WHERE id = $id");
    }
    header("Location: admin_panel.php");
    exit();
}

// Eliminar obra
if (isset($_GET['eliminar_obra'])) {
    $id = intval($_GET['eliminar_obra']);
    
    // Obtener ruta de imagen para borrar archivo
    $res = $conn->query("SELECT imagen_url FROM tu_arte WHERE id = $id");
    $obra = $res->fetch_assoc();
    if ($obra && file_exists($obra['imagen_url'])) {
        unlink($obra['imagen_url']); // Borra el archivo del servidor
    }

    $conn->query("DELETE FROM tu_arte WHERE id = $id");
    header("Location: admin_panel.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .seccion {
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f0ad4e;
            color: white;
        }
        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-eliminar:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <h1>Panel de Administrador</h1>

    <div class="seccion">
        <h2>Usuarios Registrados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acción</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM users");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['rol']}</td>
                        <td>
                        <a href='admin_panel.php?eliminar_usuario={$row['id']}' class='btn-eliminar' onclick=\"return confirm('¿Seguro que quieres eliminar este usuario?')\">Eliminar</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>

    <div class="seccion">
        <h2>Obras Subidas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>fecha_subida</th>
                <th>estilo</th>
                <th>emocion</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
            <?php
            $obras = $conn->query("SELECT * FROM tu_arte");
            while ($obra = $obras->fetch_assoc()) {
                echo "<tr>
                        <td>{$obra['id']}</td>
                        <td>{$obra['titulo']}</td>
                        <td>{$obra['autor']}</td>
                        <td>{$obra['fecha_subida']}</td>
                        <td>{$obra['estilo']}</td>
                        <td>{$obra['emocion']}</td>
                        <td><img src='{$obra['imagen_url']}' width='80'></td>
                        <td>
                       <a href='admin_panel.php?eliminar_obra={$obra['id']}' class='btn-eliminar' onclick=\"return confirm('¿Seguro que quieres eliminar esta obra?')\">Eliminar</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
