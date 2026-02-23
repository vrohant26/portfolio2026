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

    const scrambleElements = document.querySelectorAll(
      ".scramble:not(.scramble-initialized)",
    );

    scrambleElements.forEach((el) => {
      // Mark as initialized
      el.classList.add("scramble-initialized");

      const originalText = el.innerText;
      el.setAttribute("data-original-text", originalText);

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
          overwrite: true,
        });
      });
    });
  }
};

const initSwiper = () => {
  const swiperEl = document.querySelector(".mySwiper");
  // Check if it exists and hasn't been initialized yet
  if (swiperEl && !swiperEl.classList.contains("swiper-initialized")) {
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
      patternWidth: 500,
      patternHeight: 500,
      grainOpacity: 0.07,
      grainDensity: 1,
      grainWidth: 1.1,
      grainHeight: 1.1,
    };
    if (typeof window.grained === "function") {
      window.grained("#grained-container", options);
    }
  }
};

const initArchiveFilter = () => {
  const filterBtns = document.querySelectorAll(".filter-btn");
  const grid = document.querySelector(".archive-grid");
  const items = document.querySelectorAll(".archive-item");

  if (!filterBtns.length || !grid || !items.length) return;

  filterBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (btn.classList.contains("active")) return;

      // Remove active class from all
      filterBtns.forEach((b) => b.classList.remove("active"));
      // Add active class to clicked
      btn.classList.add("active");

      const filterValue = btn.getAttribute("data-filter");

      // Use GSAP to fade out the grid, swap items, then fade in
      if (typeof gsap !== "undefined") {
        gsap.to(grid, {
          duration: 0.25,
          autoAlpha: 0,
          y: 10,
          ease: "power2.in",
          onComplete: () => {
            // Filter items
            items.forEach((item) => {
              if (
                filterValue === "all" ||
                item.classList.contains(filterValue)
              ) {
                item.style.display = "flex";
              } else {
                item.style.display = "none";
              }
            });

            // Fade grid back in
            gsap.to(grid, {
              duration: 0.4,
              autoAlpha: 1,
              y: 0,
              ease: "power2.out",
            });
          },
        });
      } else {
        // Fallback without GSAP
        items.forEach((item) => {
          if (filterValue === "all" || item.classList.contains(filterValue)) {
            item.style.display = "flex";
          } else {
            item.style.display = "none";
          }
        });
      }
    });
  });
};

const initChat = () => {
  const form = document.getElementById("contact-form");
  const chatMessages = document.getElementById("chat-messages");
  const emailInput = document.getElementById("user-email");

  if (!form || !chatMessages) return;

  // The initial entrance animation is now fully handled by Barba.js via getOtherTimeline()

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // helper to add bot message with typing indicator
    const botRespond = (text, delay = 1500) => {
      const typingMsg = document.createElement("div");
      typingMsg.className =
        "chat-message bot flex align-end gap-sm typing-container";
      const themePath = window.themeData?.themeUri || window.themeUri || "";
      typingMsg.innerHTML = `
          <div class="avatar" style="margin-bottom: -10px;">
             <img src="${themePath}/assets/images/avatar.png" alt="Avatar">
          </div>
          <div class="bubble bot-bubble">
              <div class="typing-dots">
                  <span></span>
                  <span></span>
                  <span></span>
              </div>
          </div>
      `;
      chatMessages.appendChild(typingMsg);
      gsap.to(typingMsg, { opacity: 1, y: 0, duration: 0.4 });

      chatMessages.scrollTo({
        top: chatMessages.scrollHeight,
        behavior: "smooth",
      });

      setTimeout(() => {
        typingMsg.remove();
        const msg = document.createElement("div");
        msg.className = "chat-message bot flex align-end gap-sm";
        const themePath = window.themeData?.themeUri || window.themeUri || "";
        msg.innerHTML = `
          <div class="avatar" style="margin-bottom: -10px;">
             <img src="${themePath}/assets/images/avatar.png" alt="Avatar">
          </div>
          <div class="bubble bot-bubble">${text}</div>
        `;
        chatMessages.appendChild(msg);
        gsap.to(msg, { opacity: 1, y: 0, duration: 0.4 });
        chatMessages.scrollTo({
          top: chatMessages.scrollHeight,
          behavior: "smooth",
        });
      }, delay);
    };

    if (!email) {
      botRespond("You forgot to type your email!");
      return;
    }

    if (!emailRegex.test(email)) {
      botRespond(
        "That doesn't look like a valid email. Could you check it again?",
      );
      return;
    }

    // 1. Add User Message
    const userMsg = document.createElement("div");
    userMsg.className = "chat-message user flex align-end gap-sm";
    userMsg.innerHTML = `
        <div class="bubble user-bubble">
            ${email}
        </div>
    `;
    chatMessages.appendChild(userMsg);
    gsap.to(userMsg, { opacity: 1, y: 0, duration: 0.4 });

    // Clear and scroll
    emailInput.value = "";
    emailInput.blur();
    chatMessages.scrollTo({
      top: chatMessages.scrollHeight,
      behavior: "smooth",
    });

    // 2. Success Bot Response
    botRespond("Got it. Keep an eye on your inbox 👀", 2000);
  });
};

const initInteractionSounds = () => {
  const themePath = window.themeData?.themeUri || window.themeUri || "";
  const audio = new Audio(`${themePath}/assets/sound/click_002.ogg`);
  audio.load();

  const playSound = () => {
    audio.currentTime = 0;
    audio.play().catch((err) => {
      // Browser might block audio until first interaction
      console.warn("Sound play failed:", err);
    });
  };

  document.addEventListener("click", (e) => {
    const target = e.target.closest(
      "a, button, .filter-btn, .project-card-item, #theme-toggle, .send-btn, .cursor-pointer",
    );
    if (target) {
      playSound();
    }
  });

  // Also trigger for swiper navigation if any (though click on slide is covered)
};

document.addEventListener("DOMContentLoaded", () => {
  initTheme();
  initScramble();
  initSwiper();
  initGrained();
  initArchiveFilter();
  initChat();
  initInteractionSounds();
  setInterval(updateMumbaiTime, 1000);
  updateMumbaiTime();
});
