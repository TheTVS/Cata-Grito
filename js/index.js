// -------------------- CONFIG ---------------------
const isMobile = window.innerWidth <= 768;

// -------------------- SCROLL SNAP (PC) ---------------------
let isScrolling = false;
const firstSectionHeight = window.innerHeight + 10;

window.addEventListener("wheel", (e) => {
  const scrollPosition = window.scrollY;

  if (isMobile) return; // desativa snap no mobile

  if (scrollPosition < firstSectionHeight && !isScrolling) {
    isScrolling = true;

    if (e.deltaY > 0) {
      window.scrollTo({ top: firstSectionHeight, behavior: "smooth" });
    } else if (e.deltaY < 0) {
      window.scrollTo({ top: 0, behavior: "smooth" });
    }

    setTimeout(() => (isScrolling = false), 1000);
    e.preventDefault();
  }
});

// -------------------- NAVBAR ---------------------
const navbar = document.querySelector(".navbar");
const hero = document.querySelector(".hero-section");

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      navbar.classList.remove("visible");
    } else {
      navbar.classList.add("visible");
    }
  });
}, { threshold: 0.2 });

observer.observe(hero);

// -------------------- MENU MOBILE ---------------------
const navToggle = document.getElementById("nav-toggle");
navToggle.addEventListener("click", () => {
  navbar.classList.toggle("active");
});

// -------------------- CARROSSEL ---------------------
let currentIndex = 0;
let images = [];

// Preencher a lista de imagens automaticamente
document.querySelectorAll(".img-container img").forEach((img, index) => {
  const data = img.getAttribute("data-info");
  const obj = JSON.parse(data);

  images.push({
    src: obj.src,
    nome: obj.nome,
    data: obj.data,
    latitude: obj.latitude,      // <--- adicionado
    longitude: obj.longitude,    // <--- adicionado
    texto: obj.texto
});

  img.addEventListener("click", () => openCarousel(index));
});

function openCarousel(index) {
  currentIndex = index;

  const modal = document.getElementById("carouselModal");
  const imgMain = document.getElementById("carouselImage");
  const thumbLeft = document.getElementById("thumbLeft");
  const thumbRight = document.getElementById("thumbRight");

  const leftInfo = document.getElementById("carouselInfoLeft");
  const rightInfo = document.getElementById("carouselInfoRight");

  modal.style.display = "flex";

  const imgData = images[currentIndex];

  // imagem principal
  imgMain.src = imgData.src;

  // texto lateral
  leftInfo.innerHTML = `
    <table>
    <tr><td  colspan='2'>${imgData.nome}</td></tr>
    <tr><td>Data &emsp;</td><td>${imgData.data}</td></tr>
    <tr><td>Lat &emsp;</td><td>${imgData.latitude}</td></tr>
    <tr><td>Lon &emsp;</td><td>${imgData.longitude}</td></tr>
    </table>
  `;
  rightInfo.innerHTML = imgData.texto;

  // MOBILE → sem setas e thumbs
  if (window.innerWidth <= 768) {
    thumbLeft.style.display = "none";
    thumbRight.style.display = "none";
    document.getElementById("carouselPrev").style.display = "none";
    document.getElementById("carouselNext").style.display = "none";
    return;
  }

  // PC → thumbs laterais
  // thumb esquerda
  if (currentIndex === 0) {
    thumbLeft.style.display = "none";
  } else {
    thumbLeft.style.display = "block";
    thumbLeft.src = images[currentIndex - 1].src;
  }

  // thumb direita
  if (currentIndex === images.length - 1) {
    thumbRight.style.display = "none";
  } else {
    thumbRight.style.display = "block";
    thumbRight.src = images[currentIndex + 1].src;
  }
}

// --- Navegação por setas (PC)
document.getElementById("carouselPrev").onclick = () => {
  if (currentIndex > 0) openCarousel(currentIndex - 1);
};
document.getElementById("carouselNext").onclick = () => {
  if (currentIndex < images.length - 1) openCarousel(currentIndex + 1);
};

// --- Fechar modal
document.getElementById("closeCarousel").onclick = () => {
  document.getElementById("carouselModal").style.display = "none";
};

// ---- SWIPE E ZOOM (mobile)
if (window.innerWidth <= 768) {
  const imgMain = document.getElementById("carouselImage");
  let startX = 0;

  imgMain.addEventListener("touchstart", e => {
    startX = e.touches[0].clientX;
  });

  imgMain.addEventListener("touchend", e => {
    let diff = startX - e.changedTouches[0].clientX;

    if (Math.abs(diff) > 50) {
      if (diff > 0 && currentIndex < images.length - 1) {
        openCarousel(currentIndex + 1);
      } else if (diff < 0 && currentIndex > 0) {
        openCarousel(currentIndex - 1);
      }
    }
  });

  imgMain.addEventListener("click", () => {
    imgMain.classList.toggle("zoomed");
  });
}

