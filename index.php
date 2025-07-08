<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('conexion.php');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi página</title>
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/14466/14466068.png">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      
    }

    header {
      display: flex;
      justify-content: space-between;
      padding: 20px;
      background: #eee;
    }

    .btn-scroll {
      background: #888;
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
    }
    .digit {
      background-color: #eee;
      padding: 10px;
      border-radius: 8px;
      transition: transform 0.2s ease-in-out;
      cursor: pointer;
    }

    .digit:focus {
      transform: scale(1.2);
      outline: none;
      background-color: #ccc;
    }
    :root {
      --gradient-1: linear-gradient(135deg, #FF9A9E 0%, #FAD0C4 100%);/* emociones */
      --gradient-2: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
      --gradient-3: linear-gradient(135deg, #FDCB82 0%, #F37335 100%);
      --gradient-4: linear-gradient(135deg, #FAD0C4 0%, #FFD1FF 100%);
      --gradient-5: linear-gradient(135deg, #89F7FE 0%, #66A6FF 100%);
      --gradient-6: linear-gradient(135deg, #ba599e 0%, #ff87ce 100%);
      --gradient-7: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
      --gradient-8: linear-gradient(135deg, #FDCB82 0%, #F37335 100%);
       --gradient-9: linear-gradient(135deg, #FF9A9E 0%, #FAD0C4 100%);
      --gradient-10: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);

      --gradient-11: linear-gradient(135deg,#b39148 0%,#3e2518 100%); /* estilos */
      --gradient-12: linear-gradient(135deg, #2389c9  0%,#79b358 100%);
      --gradient-13: linear-gradient(135deg, #c6a620 0%, #ff8764 100%);
      --gradient-14: linear-gradient(135deg, #a795a5 0%,#128cc4 100%);
      --gradient-15: linear-gradient(135deg, #de563e 0%,#aab7ff 100% );
      --gradient-16: linear-gradient(135deg, #95040c 0%, #FFFF00 100%);
      --gradient-17: linear-gradient(135deg, #7b7fa0 0%, #009b86 100%);
      --gradient-18: linear-gradient(135deg, #6e340d 0%, #ffc2c0 100%);
      --radius-3: 12px;
      --size-1: 4px;
      --size-2: 8px;
      --size-4: 16px;
    }

    body {
      font-family: sans-serif;
      display: grid;
      place-items: center;
      min-height: 100vh;
      background: #f0f0f5;
      margin: 0;
      min-height: 100vh;
     background-image: url('');
      background-size: cover;          /* Cubre toda la pantalla */
  background-position: center;     /* Centrada */
  background-repeat: no-repeat;    /* No repetir */
  background-attachment: fixed;    /* Se mantiene al hacer scroll */
  font-family: sans-serif
    }

    h2 {
      margin-bottom: 20px;
    }
    

  .blocks {
      display: flex;
      gap: 20px;
      background: white;
      padding: 20px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .block {
      min-width: 100px;
      height: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: var(--bg);
      border-radius: 12px;
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      position: relative;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .block:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }


.block__item:hover {
  box-shadow: 0 8px 20px rgba(63, 81, 181, 0.4);
}


    .block.selected .block__item {
      border-color: black;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    button {
      margin-top: 10px;
      padding: 10px 20px;
      border: none;
      background-color: #5c6bc0;
      color: white;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }
    .imagen-efecto {
  --s: 150px;   /* tamaño de la imagen */
  --b: 8px;     /* grosor del borde */
  --g: 14px;    /* espacio en hover */
  --c: #4ECDC4; /* color del borde */

  width: var(--s);
  aspect-ratio: 1;
  outline: calc(var(--s)/2) solid #0009;
  outline-offset: calc(var(--s)/-2);
  cursor: pointer;
  transition: .3s;
}

.imagen-efecto:hover {
  outline: var(--b) solid var(--c);
  outline-offset: var(--g);
}

.imagen-efecto.redonda {
  border-radius: 50%;
}

.contenedor-imagenes {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 40px;
  margin-top: 50px;
}

    
  </style>
</head>


<body>
    
<header>
  <button onclick="location.href='login.php'">Iniciar sesión</button>
  <button onclick="location.href='Registro.php'">Registrarse</button>
  <button onclick="location.href='profile.php'">Perfil</button>
   <button type="submit">Subir obra</button>
</header>

<h1> Emociones</h1>
    <input type="hidden" name="emocion" id="emocionElegida" required>
    <form method="POST" action="subir_obra.php">
     
 <div class="blocks">
    <a href="explorar.php?emocion=Alegría" class="block" style="--bg: var(--gradient-1);">Alegría</a>
    <a href="explorar.php?emocion=tristeza" class="block" style="--bg: var(--gradient-2);">Tristeza</a>
    <a href="explorar.php?emocion=ira" class="block" style="--bg: var(--gradient-3);">Ira</a>
    <a href="explorar.php?emocion=Miedo" class="block" style="--bg: var(--gradient-4);">Miedo</a>
    <a href="explorar.php?emocion=Asco" class="block" style="--bg: var(--gradient-5);">Asco</a>
    <a href="explorar.php?emocion=Sorpresa" class="block" style="--bg: var(--gradient-6);">Sorpresa</a>
    <a href="explorar.php?emocion=Amor" class="block" style="--bg: var(--gradient-7);">Amor</a>
    <a href="explorar.php?emocion=Verguenza" class="block" style="--bg: var(--gradient-8);">Verguenza</a>
    <a href="explorar.php?emocion=Culpa" class="block" style="--bg: var(--gradient-9);">Culpa</a>
    <a href="explorar.php?emocion=Melancolia" class="block" style="--bg: var(--gradient-10);">Melancolia</a>
  </div>

 <h1>Estilos de arte<h1> 
<div class="blocks">
    <a href="explorar.php?estilo=Realismo" class="block" style="--bg: var(--gradient-11);">Realismo</a>
    <a href="explorar.php?estilo=Impresionismo" class="block" style="--bg: var(--gradient-12);">Impresionismo</a>
    <a href="explorar.php?estilo=Cubismo" class="block" style="--bg: var(--gradient-13);">Cubismo</a>
    <a href="explorar.php?estilo=Surrealismo" class="block" style="--bg: var(--gradient-14);">Surrealismo</a>
    <a href="explorar.php?estilo=Abstracto" class="block" style="--bg: var(--gradient-15);">Abstracto</a>
    <a href="explorar.php?estilo=Pop Art" class="block" style="--bg: var(--gradient-16);">Pop Art</a>
    <a href="explorar.php?estilo=Futurismo" class="block" style="--bg: var(--gradient-17);">Futurismo</a>
    <a href="explorar.php?estilo=Barroco" class="block" style="--bg: var(--gradient-18);">Barroco</a>
  </div>
 

<div class="contenedor-imagenes">
   <img src="https://i.pinimg.com/736x/ed/0d/4e/ed0d4eb492f82d9b6f5875725cf33668.jpg" alt="Ejemplo" class="imagen-efecto redonda" style="--g: 20px; --b: 5px; --c: #61401d;">
  <img src="https://i.pinimg.com/736x/ed/0d/4e/ed0d4eb492f82d9b6f5875725cf33668.jpg" alt="Ejemplo" class="imagen-efecto redonda" style="--g: 20px; --b: 5px; --c: #61401d;">
<img src="https://i.pinimg.com/736x/ed/0d/4e/ed0d4eb492f82d9b6f5875725cf33668.jpg" alt="Ejemplo" class="imagen-efecto redonda" style="--g: 20px; --b: 5px; --c: #61401d;">
    <img src="https://i.pinimg.com/736x/ed/0d/4e/ed0d4eb492f82d9b6f5875725cf33668.jpg" alt="Ejemplo" class="imagen-efecto redonda" style="--g: 20px; --b: 5px; --c: #61401d;">
     <
</div>

</body>
</html>














       