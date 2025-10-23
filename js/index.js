// ---- Scroll Snap control (scroll suave entre seções) ----
let isScrolling = false;
window.addEventListener("wheel", (e) => {
  if (isScrolling) return;
  isScrolling = true;

  const scrollPosition = window.scrollY;
  const windowHeight = window.innerHeight;

  if (e.deltaY > 0 && scrollPosition < windowHeight / 2) {
    // Scroll para baixo
    window.scrollTo({ top: windowHeight, behavior: "smooth" });
  } else if (e.deltaY < 0 && scrollPosition >= windowHeight / 2) {
    // Scroll para cima
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  setTimeout(() => (isScrolling = false), 800);
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
}, { threshold: 0.2 });

observer.observe(hero);
