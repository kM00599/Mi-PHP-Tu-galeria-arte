<?php

include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32)); 

    // Verificar si el email ya está registrado
$check_sql = "SELECT id FROM users WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "❌ Este correo ya está registrado. Intenta con otro.";
    exit();
}

    $sql = "INSERT INTO users (username, email, password, verify_token) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password,$token );

    if ($stmt->execute()) {
        
          
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <style>
    :root {
      --gradient-1: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
      --gradient-2: linear-gradient(135deg, #397290 0%, #719EBD 100%);
      --gradient-3: linear-gradient(135deg, #024383 0%, #E6CB56 100%);
      --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
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
  </style>
</head>
<body>

<form method="POST" action="">
  <h1 style="text-align: center;">Registrarse para seguir Explorando</h1>
  <input type="text" name="username" placeholder="Nombre de usuario" required>
  <input type="email" name="email" placeholder="Correo electrónico" required>
  <input type="password" name="password" placeholder="Contraseña" required>
  <button type="submit">Registrarse</button>
</form>

</body>
</html>

