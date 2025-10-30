// ---- Scroll Snap apenas na primeira seção ----
let isScrolling = false;
const firstSectionHeight = window.innerHeight + 10;

window.addEventListener("wheel", (e) => {
  const scrollPosition = window.scrollY;

  if (window.innerWidth <= 768) return; // no snap em mobile

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

// ---- Navbar visível apenas quando sai da imagem ----
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

// ---- Menu Mobile ----
const navToggle = document.getElementById("nav-toggle");
navToggle.addEventListener("click", () => {
  navbar.classList.toggle("active");
});
