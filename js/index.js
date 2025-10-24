// ---- Scroll Snap apenas na primeira seção ----
let isScrolling = false;
const firstSectionHeight = window.innerHeight+90;

window.addEventListener("wheel", (e) => {
  const scrollPosition = window.scrollY;

  // Snap só se estiver na primeira seção
  if (scrollPosition < firstSectionHeight && !isScrolling) {
    isScrolling = true;

    if (e.deltaY > 0) {
      // scroll para baixo
      window.scrollTo({ top: firstSectionHeight, behavior: "smooth" });
    } else if (e.deltaY < 0) {
      // scroll para cima
      window.scrollTo({ top: 0, behavior: "smooth" });
    }

    setTimeout(() => (isScrolling = false), 1000);
    e.preventDefault(); // previne scroll padrão
  }
});

// ---- Navbar visível apenas quando sai da imagem ----
const navbar = document.querySelector(".navbar");
const hero = document.querySelector(".hero-section");

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // Está vendo a imagem → navbar some
      navbar.classList.remove("visible");
    } else {
      // Saiu da imagem → navbar aparece
      navbar.classList.add("visible");
    }
  });
}, { threshold: 0.3 });

observer.observe(hero);
