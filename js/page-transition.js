const updateActiveLink = () => {
  const links = document.querySelectorAll("nav a");
  const currentPath = window.location.pathname.replace(/\/$/, "");

  links.forEach((link) => {
    const linkPath = new URL(link.href).pathname.replace(/\/$/, "");

    if (linkPath === currentPath) {
      link.classList.add("active");
    } else {
      link.classList.remove("active");
    }
  });
};

barba.init({
  debug: true,
  views: [
    {
      namespace: "work",

      afterEnter() {
        initSwiper();
      },
    },
  ],

  transitions: [
    {
      name: "opacity-transition",

      once(data) {
        updateActiveLink();
        initSwiper();
        initGrained();
        animationEnter(data.next.container);
      },

      leave(data) {
        const done = this.async();
        animationLeave(data.current.container, done);
      },

      enter(data) {
        initScramble();
        updateActiveLink();
        initArchiveFilter();
        initChat();
        animationEnter(data.next.container);
      },
    },
  ],
});

const animationEnter = (container) => {
  return gsap.from(container, {
    opacity: 0,
    yPercent: 2.5,
    duration: 0.3,
    clearProps: "all",
  });
};

const animationLeave = (container, done) => {
  return gsap.to(container, {
    opacity: 0,
    yPercent: -2.5,
    duration: 0.3,
    clearProps: "all",
    onComplete: () => done(),
  });
};
