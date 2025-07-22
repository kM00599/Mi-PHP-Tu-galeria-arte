<?php
include('conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

   if ($res->num_rows === 1) {
    $user = $res->fetch_assoc();
    
    if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: profile.php");
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de Sesión</title>
  <style>
    :root {
      --gradient-1: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
      --gradient-2: linear-gradient(135deg, #779663 0%, #002FA7 100%);
      --gradient-3: linear-gradient(135deg, #616bad 0%, #839868  100%);
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
      border-radius: 30px;
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
  <form method="POST" action="login.php">
    <h1 style="text-align: center;">INSPIRA Y TRANSMITE</h1>
    <h2 style="margin-bottom: 20px;">Iniciar Sesión</h2>
    <input type="email" name="email" placeholder="Correo electrónico" required>
   <input type="password" name="password" placeholder="Contraseña" required> 
    <br><button type="submit">Iniciar sesión</button><br>
    <button type="button" onclick="location.href='Registro.php'">Registrarse</button>
  </form>
</body>
</html>

