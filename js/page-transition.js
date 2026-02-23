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

// Helper to re-initialize common plugins on page enter
const reinitPlugins = () => {
  if (typeof initScramble === "function") initScramble();
  updateActiveLink();
  if (typeof initArchiveFilter === "function") initArchiveFilter();
  if (typeof initChat === "function") initChat();
};

/* ==========================================================================
   Animations
   ========================================================================== */

const getWorkTimeline = (container) => {
  const tl = gsap.timeline({ paused: true });

  const swiperSlides = container.querySelectorAll(".project-card-item");
  const briefText = container.querySelector(".brief p");

  let briefLines = [];
  if (briefText && typeof SplitType !== "undefined") {
    const split = new SplitType(briefText, { types: "lines" });
    split.lines.forEach((line) => {
      const wrapper = document.createElement("div");
      wrapper.style.overflow = "hidden";
      wrapper.style.display = "block";
      line.parentNode.insertBefore(wrapper, line);
      wrapper.appendChild(line);
    });
    briefLines = split.lines;
  } else if (briefText) {
    briefLines = [briefText];
  }

  if (swiperSlides.length > 0) {
    tl.to(
      swiperSlides,
      {
        y: "-100vh",
        duration: 2,
        stagger: 0.05,
        ease: "expo.inOut",
      },
      "-=0.5",
    );
  }

  if (briefLines.length > 0) {
    tl.to(
      briefLines,
      {
        yPercent: 100,
        duration: 2,
        stagger: 0.09,
        ease: "expo.inOut",
      },
      "-=2.5",
    );
  }

  return tl;
};

const getOtherTimeline = (container, skipBorder = false) => {
  const tl = gsap.timeline({ paused: true });

  const paragraphsAndHeaders = container.querySelectorAll(
    "h1, h2, h3, h4, h5, h6, p:not(.brief p)",
  );
  let lineTargets = [];

  if (paragraphsAndHeaders.length > 0 && typeof SplitType !== "undefined") {
    const split = new SplitType(paragraphsAndHeaders, { types: "lines" });
    split.lines.forEach((line) => {
      const wrapper = document.createElement("div");
      wrapper.style.overflow = "hidden";
      wrapper.style.display = "block";
      line.parentNode.insertBefore(wrapper, line);
      wrapper.appendChild(line);
    });
    lineTargets = split.lines;
  }

  const otherElementsNodes = container.querySelectorAll(
    "span, a:not(.logo):not(.scramble), ul li, img, .project-card-item, .archive-item, .chat-message, .chat-input-wrapper, .social-link",
  );

  const otherElements = Array.from(otherElementsNodes).filter((el) => {
    if (el.closest("h1, h2, h3, h4, h5, h6, p")) return false;
    return !Array.from(otherElementsNodes).some(
      (otherEl) => otherEl !== el && otherEl.contains(el),
    );
  });

  const wrappedElements = [];
  const unwrappedElements = [];

  // Wrap elements in overflow hidden
  otherElements.forEach((el) => {
    // Skip elements that need to overflow their bounds (like chat bubbles with tails/shadows)
    if (
      el.classList.contains("chat-message") ||
      el.classList.contains("chat-input-wrapper")
    ) {
      unwrappedElements.push(el);
      return;
    }

    wrappedElements.push(el);

    if (
      !el.parentNode.classList ||
      !el.parentNode.classList.contains("overflow-wrapper")
    ) {
      const wrapper = document.createElement("div");
      wrapper.className = "overflow-wrapper";
      wrapper.style.overflow = "hidden";
      wrapper.style.display =
        window.getComputedStyle(el).display === "inline"
          ? "inline-block"
          : "block";
      el.parentNode.insertBefore(wrapper, el);
      wrapper.appendChild(el);
    }
  });

  if (wrappedElements.length > 0) {
    tl.fromTo(
      wrappedElements,
      { yPercent: 120 },
      {
        yPercent: 0,
        stagger: 0.05,
        duration: 2,
        ease: "expo.inOut",
      },
      "-=0.2",
    );
  }

  if (unwrappedElements.length > 0) {
    tl.fromTo(
      unwrappedElements,
      { yPercent: 120 },
      {
        yPercent: 0,
        stagger: 0.05,
        duration: 2,
        ease: "expo.inOut",
      },
      "-=1",
    );
  }

  if (lineTargets.length > 0) {
    tl.fromTo(
      lineTargets,
      { yPercent: 100 },
      {
        yPercent: 0,
        duration: 2,

        stagger: -0.05,
        ease: "expo.inOut",
      },
      0,
    );
  } else if (paragraphsAndHeaders.length > 0) {
    tl.fromTo(
      paragraphsAndHeaders,
      { yPercent: 100 },
      { yPercent: 0, duration: 2, delay: 0.5, ease: "expo.inOut" },
      0,
    );
  }

  const topEl = container.querySelector(".top");
  if (topEl && !skipBorder) {
    tl.fromTo(
      topEl,
      { "--border-progress": "0%", opacity: 0 },
      {
        "--border-progress": "100%",
        opacity: 1,
        duration: 2.5,
        ease: "expo.inOut",
      },
      0,
    );
  }

  return tl;
};

const animationWorkToOtherLeave = (container, done) => {
  gsap.set(container, {
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    zIndex: 1,
  });
  const tl = getWorkTimeline(container);
  tl.eventCallback("onComplete", done);
  tl.play();
};

const animationWorkToOtherEnter = (container) => {
  gsap.set(container, { opacity: 1, zIndex: 2 });
  const tl = getOtherTimeline(container);

  // Wait before playing the entrance animation
  gsap.delayedCall(0, () => {
    tl.play();
  });
};

const animationOtherToWorkLeave = (container, done) => {
  gsap.set(container, {
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    zIndex: 1,
  });
  const tl = getOtherTimeline(container);
  tl.eventCallback("onReverseComplete", done);
  tl.progress(1).reverse();
};

const animationOtherToWorkEnter = (container) => {
  gsap.set(container, { opacity: 1, zIndex: 2 });
  if (typeof initSwiper === "function") initSwiper();

  const tl = getWorkTimeline(container);

  // Immediately put the elements in their hidden 'end' state
  tl.progress(1);

  // Explicitly wait 0.5s before playing the reverse animation
  gsap.delayedCall(0, () => {
    tl.reverse();
  });
};

const animationFadeLeave = (container, done, skipBorder = false) => {
  gsap.set(container, {
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    zIndex: 1,
  });
  const tl = getOtherTimeline(container, skipBorder);
  tl.eventCallback("onReverseComplete", done);
  tl.progress(1).reverse();
};

const animationSimpleFadeLeave = (container, done) => {
  gsap.set(container, {
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    zIndex: 1,
  });
  gsap.to(container, {
    opacity: 0,
    duration: 1,
    ease: "power2.out",
  });
  // Pad the transition time to exactly 2s so the container doesn't disappear early while the next page is entering
  gsap.delayedCall(2, done);
};

const animationFadeEnter = (container, skipBorder = false) => {
  gsap.set(container, { opacity: 1, zIndex: 2 });
  const tl = getOtherTimeline(container, skipBorder);

  // Explicitly wait 1s before playing the entrance animation, preventing overlap with the 2s exit transition
  gsap.delayedCall(1, () => {
    tl.play();
  });
};

/* ==========================================================================
   Barba Init
   ========================================================================== */

const getSkipBorder = (data) =>
  data.current.container.querySelector(".top") &&
  data.next.container.querySelector(".top");

barba.hooks.before(() => {
  document.body.style.pointerEvents = "none";
});

barba.hooks.after(() => {
  document.body.style.pointerEvents = "auto";
});

if (typeof barbaPrefetch !== "undefined") {
  barba.use(barbaPrefetch);
}

barba.init({
  debug: true,
  views: [
    {
      namespace: "work",
      afterEnter() {
        if (typeof initSwiper === "function") initSwiper();
      },
    },
  ],

  transitions: [
    {
      name: "to-contact-transition",
      sync: true,
      to: {
        namespace: ["contact"],
      },
      leave(data) {
        const done = this.async();
        if (data.current.namespace === "work") {
          animationWorkToOtherLeave(data.current.container, done);
        } else {
          animationFadeLeave(data.current.container, done, getSkipBorder(data));
        }
      },
      enter(data) {
        reinitPlugins();
        gsap.set(data.next.container, { opacity: 0, zIndex: 2 });
        gsap.to(data.next.container, {
          opacity: 1,
          duration: 1,
          delay: 1,
          ease: "power2.out",
        });
      },
    },
    {
      name: "other-to-work-transition",
      sync: true,
      to: {
        namespace: ["work"],
      },
      leave(data) {
        const done = this.async();
        // Use fade out if coming from contact page
        if (data.current.namespace === "contact") {
          animationSimpleFadeLeave(data.current.container, done);
        } else {
          animationOtherToWorkLeave(data.current.container, done);
        }
      },
      enter(data) {
        reinitPlugins();
        animationOtherToWorkEnter(data.next.container);
      },
    },
    {
      name: "work-to-other-transition",
      sync: true,
      from: {
        namespace: ["work"],
      },
      leave(data) {
        const done = this.async();
        animationWorkToOtherLeave(data.current.container, done);
      },
      enter(data) {
        reinitPlugins();
        animationWorkToOtherEnter(data.next.container);
      },
    },
    {
      name: "fade-transition",
      sync: true,

      once(data) {
        updateActiveLink();
        if (typeof initSwiper === "function") initSwiper();
        if (typeof initGrained === "function") initGrained();

        gsap.set(data.next.container, { autoAlpha: 1 });

        const topEl = data.next.container.querySelector(".top");
        if (topEl) {
          gsap.fromTo(
            topEl,
            { "--border-progress": "0%" },
            {
              "--border-progress": "100%",
              duration: 1,
              ease: "power2.out",
              delay: 0.2,
            },
          );
        }
      },

      leave(data) {
        const done = this.async();
        if (data.current.namespace === "contact") {
          animationSimpleFadeLeave(data.current.container, done);
        } else {
          animationFadeLeave(data.current.container, done, getSkipBorder(data));
        }
      },

      enter(data) {
        reinitPlugins();
        animationFadeEnter(data.next.container, getSkipBorder(data));
      },
    },
  ],
});
