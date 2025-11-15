<?php
include 'php/process_uploads.php';
include('php/conexao.php');

// Consulta todas as fotos com seus eventos
$sql = "SELECT f.id, f.data, f.grito, f.caminho_foto, 
               e.nome AS evento_nome, e.latitude, e.longitude
        FROM foto f
        INNER JOIN evento e ON f.evento_id = e.id
        ORDER BY f.id DESC
        LIMIT 12";

$resultado = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.cdnfonts.com/css/neue-haas-unica" rel="stylesheet">
  <link rel="stylesheet" href="../css/index_css.css">
  <title>CATA-GRITO</title>
</head>

<body>
  <nav class="navbar">
    <div class="nav-mobile-toggle" id="nav-toggle">☰</div>

    <ul class="nav-left">
      <li><a href="../html/sobre_nos.html">SOBRE NÓS</a></li>
      <li><a href="#projeto">O PROJETO</a></li>
    </ul>

    <div class="nav-center">
      <div class="logo"></div>
      <h1><a href="index.php">CATA-GRITO</a></h1>
    </div>

    <ul class="nav-right">
      <li><a href="php/galeria.php">GALERIA</a></li>
      <li><a href="../html/manifesto.html">MANIFESTO</a></li>
    </ul>
  </nav>

  <main class="snap-container">
    <section class="hero-section">
      <img src="../img/fundo.png" alt="Imagem de fundo" class="hero-image">
    </section>

    <section class="content-section">
      <br><br>
      <table class="image-table">
      <?php
        if ($resultado->num_rows > 0) {
            $count = 0;
            echo "<tr>";
            while ($linha = $resultado->fetch_assoc()) {

                // Prepara o JSON do data-info
                $info = [
                  "src" => "../" . $linha["caminho_foto"],
                  "nome" => $linha["evento_nome"],
                  "data" => $linha["data"],
                  "serial" => $linha["grito"],
                  "texto" => "Lorem ipsum dolor sit amet, descrição da foto..."
                ];
                $info_json = htmlspecialchars(json_encode($info), ENT_QUOTES, 'UTF-8');

                echo "
                <td>
                  <div class='img-container'>
                    <img 
                      src='../{$linha["caminho_foto"]}' 
                      alt='Foto'
                      data-info='{$info_json}'
                    >

                    <div class='img-info'>
                      <p>" . htmlspecialchars($linha['data']) . "</p><br><br><br><br><br>
                      <p>" . htmlspecialchars($linha['latitude']) . "</p>
                      <p>" . htmlspecialchars($linha['longitude']) . "</p>
                    </div>
                  </div>
                </td>";

                $count++;
                if ($count % 4 == 0) echo "</tr><tr>";
            }
            echo "</tr>";
        } else {
            echo "<tr><td colspan='4'>Nenhuma foto encontrada.</td></tr>";
        }

        $conexao->close();
      ?>
      </table>
    </section>
  </main>

  <!-- CARROSSEL -->
  <div id="carouselModal" class="carousel-modal">
    <div class="carousel-wrapper">

      <span class="carousel-arrow left" id="carouselPrev">&#8592;</span>
      <span class="carousel-arrow right" id="carouselNext">&#8594;</span>

      <!-- imagem principal -->
      <img id="carouselImage" class="carousel-main-img">

      <!-- miniaturas -->
      <div class="carousel-thumb left-thumb">
        <img id="thumbLeft" src="">
      </div>

      <div class="carousel-thumb right-thumb">
        <img id="thumbRight" src="">
      </div>

      <!-- infos e texto -->
      <div class="carousel-info-area">
        <div class="carousel-left-info" id="carouselInfoLeft"></div>

        <div class="carousel-right-info" id="carouselInfoRight"></div>
      </div>

    </div>

    <span class="close-carousel" id="closeCarousel">&times;</span>
  </div>

  <script src="../js/index.js"></script>
</body>
</html>
