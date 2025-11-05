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
  <link rel="stylesheet" href="../css/sobre_noscss.css">
  <title>CATA-GRITO</title>
</head>
<body style ="background-color: #000000;">
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
      <li><a href="#galeria">GALERIA</a></li>
      <li><a href="../html/manifesto.html">MANIFESTO</a></li>
    </ul>
  </nav>

      <table class="image-table" style="margin-top: 250px;">
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
  </main>

  <script>
    const navToggle = document.getElementById("nav-toggle");
    const navbar = document.querySelector(".navbar");

    navToggle.addEventListener("click", () => {
        navbar.classList.toggle("active");
    });
  </script>
</body>
</html>
