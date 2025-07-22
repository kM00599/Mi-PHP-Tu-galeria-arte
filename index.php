<?php
session_start();
include('conexion.php');

$foto_perfil = null;


// Obtener datos del usuario
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_usuario = "SELECT username, imagen_perfil FROM users WHERE id = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $user_id);
    $stmt_usuario->execute();
    $resultado_usuario = $stmt_usuario->get_result();
    $usuario = $resultado_usuario->fetch_assoc();

    // Imagen de perfil (usa una por defecto si no hay)
    $foto_perfil = !empty($usuario['imagen_perfil']) ? $usuario['imagen_perfil'] : 'default_profile.png';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arte y Emociones</title>
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/14466/14466068.png">
  <style>
    :root {
      --gradient-1: linear-gradient(135deg, #FF9A9E 0%, #FAD0C4 100%); /* Emociones */
      --gradient-2: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
      --gradient-3: linear-gradient(135deg, #FDCB82 0%, #F37335 100%);
      --gradient-4: linear-gradient(135deg, #FAD0C4 0%, #FFD1FF 100%);
      --gradient-5: linear-gradient(135deg, #89F7FE 0%, #66A6FF 100%);
      --gradient-6: linear-gradient(135deg, #ba599e 0%, #ff87ce 100%);
      --gradient-7: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
      --gradient-8: linear-gradient(135deg, #FDCB82 0%, #F37335 100%);
      --gradient-9: linear-gradient(135deg, #FF9A9E 0%, #FAD0C4 100%);
      --gradient-10: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);

      --gradient-11: linear-gradient(135deg,#b39148 0%,#3e2518 100%); /* Estilos */
      --gradient-12: linear-gradient(135deg, #2389c9  0%,#79b358 100%);
      --gradient-13: linear-gradient(135deg, #c6a620 0%, #ff8764 100%);
      --gradient-14: linear-gradient(135deg, #a795a5 0%,#128cc4 100%);
      --gradient-15: linear-gradient(135deg, #de563e 0%,#aab7ff 100%);
      --gradient-16: linear-gradient(135deg, #95040c 0%, #FFFF00 100%);
      --gradient-17: linear-gradient(135deg, #7b7fa0 0%, #009b86 100%);
      --gradient-18: linear-gradient(135deg, #6e340d 0%, #ffc2c0 100%);
    }

    * {
      box-sizing: border-box;
    }

    body {
        
       margin: 0;
  padding: 0;
  font-family: 'Acme', sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 100vh;
  background: linear-gradient(-45deg, #451502, #3a0e02,#2f0701, #240000);
  background-size: 400% 400%;
  animation: gradientBG 15s ease infinite;
    
      
    }

    header {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      padding: 20px;
      background: #eee;
      width: 100%;
      
    }

    button {
      padding: 10px 20px;
      border: none;
      background-color:#3d050d;
      color: white;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    h1 {
      text-align: center;
    }

    .blocks {
      display: flex;
      overflow-x: auto;
      gap: 12px;
      padding: 12px;
      background: white;
      border-radius: 16px;
      scroll-snap-type: x mandatory;
      -webkit-overflow-scrolling: touch;
      max-width: 95vw;
      margin-bottom: 20px;
    }

    .block {
      scroll-snap-align: start;
      flex-shrink: 0;
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
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .block:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .container {
  max-width: 1200px;
  margin: 50px auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}
    .galeria-pintores {
  padding: 40px 20px;
  text-align: center;
}

.cards-pintores {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
}

.card-pintor {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  overflow: hidden;
  width: 260px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.card-pintor:hover {
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.card-pintor img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.card-pintor h3 {
  margin: 15px 10px 5px;
  font-size: 1.2em;
  color: #333;
}

.card-pintor p {
  padding: 0 15px 15px;
  font-size: 0.95em;
  color: #555;
}

.perfil-container {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .btn-perfil {
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
        }
        .btn-perfil img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }



 
    @media (max-width: 768px) {
      .block {
        min-width: 80px;
        height: 50px;
        font-size: 14px;
      }

      .imagen-efecto {
        --s: 100px;
      }
    }

    @keyframes gradientBG {
  0% {
    background-position: 10% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 10% 50%;
  }
}

  </style>
</head>
<body>
  <header>
    <button onclick="location.href='login.php'">Iniciar sesión</button>
    <button onclick="location.href='Registro.php'">Registrarse</button>
    <button onclick="location.href='subir_obra.php'">Subir obra</button>
  </header>

  <h1 style="color:white">Bienvenido a Arte y Emociones</h1>
  <p style="color:white; text-align:center; max-width: 800px; margin: auto;">Este sitio te invita a explorar el arte desde el corazón. Recorre estilos, emociones y artistas que han transformado sentimientos en obras eternas. ¡Déjate llevar!</p>

  <h1></h1>
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

  <h1></h1>
  <div class="blocks">
    <a href="explorar.php?estilo=Realismo" class="block" style="--bg: var(--gradient-11);">Realismo</a>
    <a href="explorar.php?estilo=Impresionismo" class="block" style="--bg: var(--gradient-12);">Impresionismo</a>
    <a href="explorar.php?estilo=Cubismo" class="block" style="--bg: var(--gradient-13);">Cubismo</a>
    <a href="explorar.php?estilo=Surrealismo" class="block" style="--bg: var(--gradient-14);">Surrealismo</a>
    <a href="explorar.php?estilo=Abstracto" class="block" style="--bg: var(--gradient-15);">Abstracto</a>
    <a href="explorar.php?estilo=Pop Art" class="block" style="--bg: var(--gradient-16);">Pop Art</a>
    <a href="explorar.php?estilo=Futurismo" class="block" style="--bg: var(--gradient-17);">Futurismo</a>
    <a href="explorar.php?estilo=Barroco" class="block" style="--bg: var(--gradient-18);">Barroco</a>
    <a href="explorar.php?estilo=fan art" class="block" style="--bg: var(--gradient-18);">fan art</a>
  </div>

    <section class="galeria-pintores">
  <h2></h2>
  <div class="cards-pintores">
    <div class="card-pintor">
      <img src="https://uploads7.wikiart.org/images/gustave-courbet.jpg!Portrait.jpg" alt="Gustave Courbet">
      <h3>Realismo</h3>
      <p>Gustave Courbet (Francia, s. XIX) </p><p>Pintaba escenas cotidianas con gran detalle y sin idealización. Mostraba la vida tal cual era, especialmente de campesinos y obreros.</p>
    </div>
    <div class="card-pintor">
      <img src="https://historia-arte.com/_/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpbSI6WyJcL2FydGlzdFwvaW1hZ2VGaWxlXC81MjE2OTI3NDFfNDA2ZDNjNzZmZS5qcGciLCJyZXNpemVDcm9wLDQwMCw0MDAsQ1JPUF9FTlRST1BZIl19.otAlKFb-XXsDXPaTf_bCb-mB1MTt0N_onoKEGQ5QgX/0.jpg" alt="Claude Monet">
      <h3>Expresionismo</h3>
      <p>Claude Monet (Francia, s. XIX)</p><p>Usaba pinceladas rápidas y colores brillantes. Pintaba al aire libre para capturar los efectos de la luz en diferentes momentos del día.</p>
    </div>
    <div class="card-pintor">
      <img src="https://www.65ymas.com/uploads/s1/59/29/6/picasso-14_1_621x621.jpeg" alt="Pablo Picasso">
      <h3>Cubismo</h3>
      <p>	Pablo Picasso (España, s. XX)</p><P>Rompía las formas naturales en figuras geométricas. Mostraba diferentes ángulos al mismo tiempo, como en Las Señoritas de Avignon.</P>
    </div>
     <div class="card-pintor">
      <img src="https://www.cultura.gob.ar/media/uploads/dali1.jpg" alt="Salvador Dalí">
      <h3>	Surrealismo</h3>
      <p>Salvador Dalí (España, s. XX)</p><P>Pintaba imágenes de sueños y símbolos inconscientes. Sus obras tienen paisajes irreales, relojes derretidos y figuras deformadas.</p>
    </div>
     <div class="card-pintor">
      <img src="https://mytaleiteach.com/wp-content/uploads/2013/01/kandinsky-en-su-estudio.jpg?w=630" alt="Wassily Kandinsky">
      <h3>Abstracto</h3>
      <p>	Wassily Kandinsky (Rusia, s. XX)</p><P>No representaba figuras. Usaba formas, colores y líneas para expresar emociones y espiritualidad. Se le considera uno de los padres del arte abstracto.</P>
    </div>
     <div class="card-pintor">
      <img src="https://cdn.britannica.com/81/226581-004-C3C467C6/Andy-Warhol-at-Jewish-Museum-New-York-City-1980.jpg?w=400&h=300&c=crop" alt="Andy Warhol">
      <h3>	Pop Art</h3>
      <p>	Andy Warhol (EE.UU., s. XX)</p><P>Usaba imágenes de la cultura popular (sopas Campbell, Marilyn Monroe). Colores planos, repetición y estilo gráfico, casi como publicidad.</P>
    </div>
     <div class="card-pintor">
      <img src="https://encrypted-tbn2.gstatic.com/licensed-image?q=tbn:ANd9GcR1ptrnEsTOSIx2_Ow5IRLSEelfA91JuRwFn2_WkSG7QDN6do8OT-znMG_Ysj0W_lg7m_G7sRYmFDjUzVI" alt="Umberto Boccioni">
      <h3>	Futurismo</h3>
      <p>Umberto Boccioni (Italia, s. XX)</p><P>Mostraba movimiento, energía y tecnología. Las figuras parecen estar en acción, con formas dinámicas y líneas en movimiento.</P>
    </div>
     <div class="card-pintor">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Bild-Ottavio_Leoni%2C_Caravaggio.jpg/800px-Bild-Ottavio_Leoni%2C_Caravaggio.jpg" alt="Caravaggio">
      <h3>Barroco	</h3>
      <p>	Caravaggio (Italia, s. XVI–XVII)</p><P>Usaba contrastes dramáticos de luz y sombra (claroscuro). Sus obras son teatrales, intensas y muestran emociones humanas profundas..</P>
    </div>
  </div>
  </section>
  <?php if (isset($_SESSION['user_id'])): ?>
<div class="perfil-container">
        <form action="profile.php" method="get">
            <button type="submit" class="btn-perfil" title="Perfil">
                <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de perfil">
            </button>
        </form>
    </div>
    <?php endif; ?>

    <section style="color: white; text-align:center; padding: 20px;">
    <h2>Frases que inspiran</h2>
    <blockquote><i>"El arte no reproduce lo visible, lo hace visible."</i> – Paul Klee</blockquote>
    <blockquote><i>"El arte es la mentira que nos permite comprender la verdad."</i> – Pablo Picasso</blockquote>
  </section>
  <section style="background:white; padding: 30px; max-width:900px; margin:auto; border-radius: 12px;">
    <h2 style="text-align:center;">¿Qué significa cada estilo?</h2>
    <ul>
      <li><strong>Realismo:</strong> Representa la realidad con precisión y detalle.</li>
      <li><strong>Surrealismo:</strong> Arte de los sueños, la fantasía y el inconsciente.</li>
      <li><strong>Pop Art:</strong> Usa la cultura pop como inspiración con colores vivos.</li>
      <li><strong>Cubismo:</strong> Muestra varias perspectivas a la vez mediante formas geométricas.</li>
      <li><strong>Abstracto:</strong> No busca representar la realidad, sino emociones con color y forma.</li>
    </ul>
  </section>

  <section style="padding: 40px; text-align:center;">
    <h2 style="color:white">¿Qué emoción estás sintiendo?</h2>
    <p style="color:white">Haz clic en una emoción para ver obras relacionadas con tu estado emocional actual.</p>
    <button onclick="location.href='explorar.php'">Explorar ahora</button>
  </section>

</body>
</html>















       