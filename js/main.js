const initTheme = () => {
  const toggle = document.getElementById("theme-toggle");
  const status = document.getElementById("theme-status");
  const body = document.body;

  // Check for saved theme
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "light") {
    body.classList.add("light-mode");
    if (status) status.textContent = "Dark Mode";
  } else {
    if (status) status.textContent = "Light Mode";
  }

  if (toggle) {
    toggle.addEventListener("click", () => {
      body.classList.toggle("light-mode");
      const isLight = body.classList.contains("light-mode");
      localStorage.setItem("theme", isLight ? "light" : "dark");
      if (status) status.textContent = isLight ? "Dark Mode" : "Light Mode";
    });
  }
};

function updateMumbaiTime() {
  const options = {
    timeZone: "Asia/Kolkata",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: true,
  };

  const time = new Intl.DateTimeFormat("en-IN", options).format(new Date());
  document.getElementById("mumbai-time").textContent = time;
}

const initScramble = () => {
  if (
    typeof gsap !== "undefined" &&
    typeof ScrambleTextPlugin !== "undefined"
  ) {
    if (window.innerWidth <= 1024) return;

    gsap.registerPlugin(ScrambleTextPlugin);

    const scrambleElements = document.querySelectorAll(".scramble");

    scrambleElements.forEach((el) => {
      const originalText = el.innerText;

      // Lock width to prevent layout shift
      const rect = el.getBoundingClientRect();
      el.style.width = `${rect.width}px`;
      el.style.display = "inline-block";
      el.style.whiteSpace = "nowrap";

      el.addEventListener("mouseenter", () => {
        gsap.to(el, {
          duration: 0.5,
          scrambleText: {
            text: originalText,
            chars: "uppercase",
          },
        });
      });
    });
  }
};

const initSwiper = () => {
  if (document.querySelector(".mySwiper")) {
    new Swiper(".mySwiper", {
      direction: "horizontal",
      spaceBetween: 180,
      slidesPerView: 1.8,
      speed: 700,
      loop: true,
      centeredSlides: true,
      mousewheel: true,
      breakpoints: {
        768: {
          spaceBetween: 120,
        },
      },
    });
  }
};

const initGrained = () => {
  const grainedEl = document.querySelector("#grained-container");
  if (grainedEl) {
    const options = {
      animate: true,
      patternWidth: 100,
      patternHeight: 100,
      grainOpacity: 0.05,
      grainDensity: 1,
      grainWidth: 1,
      grainHeight: 1,
    };
    if (typeof window.grained === "function") {
      window.grained("#grained-container", options);
    }
  }
};

document.addEventListener("DOMContentLoaded", () => {
  initTheme();
  initScramble();
  initSwiper();
  initGrained();
  setInterval(updateMumbaiTime, 1000);
  updateMumbaiTime();
});
