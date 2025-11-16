<?php
include('conexao.php');

// Consulta todas as fotos com seus eventos
$sql = "SELECT f.id, f.data, f.grito, f.caminho_foto, 
               e.nome AS evento_nome, e.latitude, e.longitude, e.descricao
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

  <style>
    /* --- MESMO CSS DO SITE PRINCIPAL PARA HOVER --- */
    .img-container {
      position: relative;
      display: inline-block;
    }

    .img-info {
      text-align: right;
      position: absolute;
      bottom: 10px;
      right: 10px;
      width: 100%;
      color: #FF2D2D;
      padding: 10px;
      font-size: 20px;
      opacity: 0;
      cursor: pointer;
      pointer-events: none;
    }

    .img-container:hover .img-info {
      opacity: 1;
    }

    @media (max-width:768px){
      .img-info{
        bottom: 15px;
        right: 30px;
      }
    }

    /* --- CARROSSEL CSS IMPORTADO DO ARQUIVO PRINCIPAL --- */

    .carousel-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: black;
      z-index: 9999;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      font-size: 25px
    }

    .carousel-wrapper {
      width: 100%;
      max-width: 1200px;
      margin-top: 80px;
      text-align: center;
      position: relative;
    }

    .carousel-main-img {
      width: 90%;
      max-width: 900px;
      height: auto;
      transition: transform 0.3s;
    }

    .carousel-main-img.zoomed {
      transform: scale(2);
    }

    .carousel-arrow {
      position: absolute;
      top: 50%;
      font-size: 80px;
      color: white;
      cursor: pointer;
      user-select: none;
      transform: translateY(-50%);
      z-index: 20;
    }

    .carousel-arrow.left { left: -60px; }
    .carousel-arrow.right { right: -60px; }

    .carousel-thumb {
      width: 120px;
      height: 70px;
      overflow: hidden;
      position: absolute;
      bottom: 190px;
    }

    .carousel-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .left-thumb { left: 10px; }
    .right-thumb { right: 10px; }

    .carousel-info-area {
      display: flex;
      justify-content: space-between;
      padding: 30px 60px;
      color: white;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    .carousel-left-info {
      width: 40%;
      text-align: left;
    }

    .carousel-right-info {
      width: 55%;
      text-align: left;
      line-height: 24px;
    }

    .close-carousel {
      position: fixed;
      top: 20px;
      right: 40px;
      font-size: 60px;
      color: white;
      cursor: pointer;
      z-index: 10000;
    }

    @media (max-width:768px){
      .carousel-info-area{
        flex-direction: column;
        gap:20px;
      }

      .carousel-arrow, .carousel-thumb{
        display:none!important;
      }
    }
    /* === GRID DA GALERIA NO MOBILE === */
@media (max-width: 768px) {

  .image-table tr {
    display: block;              /* cada linha vira um bloco */
  }

  .image-table td {
    display: block;              /* cada imagem ocupa a própria linha */
    width: 100% !important;      /* largura total */
    padding: 10px 0 40px 0;      /* espaço entre imagens */
    text-align: center;
  }

  .image-table img {
    width: 90%;                  /* imagem grande e centralizada */
    max-width: 380px;
    height: auto;
    margin: 0 auto;
  }

  /* esconde o hover vermelho no mobile */
  .img-info {
    opacity: 1 !important;
    font-size: 16px;
    bottom: 10px;
    right: 10px;
  }
}

  </style>
</head>
<body style="background-color:#000;">
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

  <table class="image-table" style="margin-top:250px;">
  <?php
    if ($resultado->num_rows > 0) {
        $count = 0;
        echo "<tr>";
        while ($linha = $resultado->fetch_assoc()) {

            $info = [
                "src" => "../" . $linha["caminho_foto"],
                "nome" => $linha["evento_nome"],
                "data" => $linha["data"],
                "latitude" => $linha["latitude"],
                "longitude" => $linha["longitude"],
                "texto" => $linha["descricao"] ?? ""
            ];
            $info_json = json_encode($info, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            echo "
            <td>
              <div class='img-container'>
                <img src='../{$linha['caminho_foto']}' alt='Foto' data-info='{$info_json}'>
                <div class='img-info'>
                  <p>{$linha['data']}</p><br><br><br>
                  <p>{$linha['latitude']}</p>
                  <p>{$linha['longitude']}</p>
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

  <!-- === CARROSSEL AGORA ADICIONADO === -->
  <div id="carouselModal" class="carousel-modal">
    <div class="carousel-wrapper">
      <span class="carousel-arrow left" id="carouselPrev">&#8592;</span>
      <span class="carousel-arrow right" id="carouselNext">&#8594;</span>

      <img id="carouselImage" class="carousel-main-img">

      <div class="carousel-thumb left-thumb">
        <img id="thumbLeft">
      </div>

      <div class="carousel-thumb right-thumb">
        <img id="thumbRight">
      </div>

      <div class="carousel-info-area">
        <div class="carousel-left-info" id="carouselInfoLeft"></div>
        <div class="carousel-right-info" id="carouselInfoRight"></div>
      </div>
    </div>

    <span class="close-carousel" id="closeCarousel">&times;</span>
  </div>

  <!-- === MESMO JS DO SITE PRINCIPAL === -->
  <script>
  let currentIndex = 0;
  let images = [];

  document.querySelectorAll(".img-container img").forEach((img, index) => {
    const data = img.getAttribute("data-info");
    const obj = JSON.parse(data);

    images.push(obj);

    img.addEventListener("click", () => openCarousel(index));
  });

  function openCarousel(index){
    currentIndex = index;

    const modal = document.getElementById("carouselModal");
    const imgMain = document.getElementById("carouselImage");
    const thumbLeft = document.getElementById("thumbLeft");
    const thumbRight = document.getElementById("thumbRight");
    const leftInfo = document.getElementById("carouselInfoLeft");
    const rightInfo = document.getElementById("carouselInfoRight");

    modal.style.display="flex";

    const imgData = images[currentIndex];

    imgMain.src = imgData.src;

    leftInfo.innerHTML = `
      <table>
      <tr><td colspan='2'>${imgData.nome}</td></tr>
      <tr><td>Data</td><td>${imgData.data}</td></tr>
      <tr><td>Lat</td><td>${imgData.latitude}</td></tr>
      <tr><td>Lon</td><td>${imgData.longitude}</td></tr>
      </table>
    `;

    rightInfo.innerHTML = imgData.texto;

    if(window.innerWidth<=768){
      thumbLeft.style.display="none";
      thumbRight.style.display="none";
      document.getElementById("carouselPrev").style.display="none";
      document.getElementById("carouselNext").style.display="none";
      return;
    }

    if(currentIndex===0){
      thumbLeft.style.display="none";
    } else {
      thumbLeft.style.display="block";
      thumbLeft.src = images[currentIndex-1].src;
    }

    if(currentIndex===images.length-1){
      thumbRight.style.display="none";
    } else {
      thumbRight.style.display="block";
      thumbRight.src = images[currentIndex+1].src;
    }
  }

  document.getElementById("carouselPrev").onclick = () => {
    if(currentIndex>0) openCarousel(currentIndex-1);
  };

  document.getElementById("carouselNext").onclick = () => {
    if(currentIndex < images.length -1) openCarousel(currentIndex+1);
  };

  document.getElementById("closeCarousel").onclick = () => {
    document.getElementById("carouselModal").style.display="none";
  };
  // ======== SUPORTE A SWIPE NO MOBILE ========
let startX = 0;
let endX = 0;

const modal = document.getElementById("carouselModal");
const imgMain = document.getElementById("carouselImage");

// Quando começa o toque
imgMain.addEventListener("touchstart", (e) => {
  startX = e.touches[0].clientX;
});

// Enquanto arrasta
imgMain.addEventListener("touchmove", (e) => {
  endX = e.touches[0].clientX;
});

// Quando solta o dedo
imgMain.addEventListener("touchend", () => {
  let diff = startX - endX;

  // Sensibilidade mínima de 50px
  if (Math.abs(diff) > 50) {

    // Arrastou para a esquerda → próxima imagem
    if (diff > 0 && currentIndex < images.length - 1) {
      openCarousel(currentIndex + 1);
    }

    // Arrastou para a direita → imagem anterior
    if (diff < 0 && currentIndex > 0) {
      openCarousel(currentIndex - 1);
    }
  }
});
  </script>

</body>
</html>
