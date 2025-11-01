<?php
include('conexao.php');

// Consulta todas as fotos com seus eventos
$sql = "SELECT f.id, f.data, f.grito, f.caminho_foto, e.nome AS evento_nome
        FROM foto f
        INNER JOIN evento e ON f.evento_id = e.id
        ORDER BY f.id DESC";

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
      <h1><a href="index.html">CATA-GRITO</a></h1>
    </div>

    <ul class="nav-right">
      <li><a href="#galeria">GALERIA</a></li>
      <li><a href="#manifesto">MANIFESTO</a></li>
    </ul>
  </nav>

  <main class="snap-container">
    <!-- Seção da imagem -->
    <section class="hero-section">
      <img src="../img/fundo.png" alt="Imagem de fundo" class="hero-image">
    </section>

    <!-- Conteúdo -->
    <section class="content-section">
      <table class="image-table">
      <?php
        if ($resultado->num_rows > 0) {
            $count = 0;
            echo "<tr>";
            while ($linha = $resultado->fetch_assoc()) {
                echo "<td><img src='../" . htmlspecialchars($linha['caminho_foto']) . "' alt='Foto'></td>";
                $count++;

                // Quebra de linha a cada 4 imagens
                if ($count % 4 == 0) {
                    echo "</tr><tr>";
                }
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

  <script src="../js/index.js"></script>
</body>
</html>
