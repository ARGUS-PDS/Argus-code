document.addEventListener("DOMContentLoaded", function () {
    AOS.init({
        duration: 1000,
        once: true,
        easing: "ease-in-out",
    });

    const mobileMenuBtn = document.getElementById("mobile-menu-btn");
    const navLinks = document.getElementById("nav-links");

    mobileMenuBtn.addEventListener("click", () => {
        navLinks.classList.toggle("active");
        mobileMenuBtn.innerHTML = navLinks.classList.contains("active")
            ? '<i class="fas fa-times"></i>'
            : '<i class="fas fa-bars"></i>';
    });

    document.querySelectorAll(".nav-links a").forEach((link) => {
        link.addEventListener("click", () => {
            navLinks.classList.remove("active");
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute("href")).scrollIntoView({
                behavior: "smooth",
            });
        });
    });

    window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
            navbar.style.backgroundColor = "rgba(0, 0, 0, 0.95)";
            navbar.style.padding = "10px 0";
        } else {
            navbar.style.backgroundColor = "rgba(0, 0, 0, 0.8)";
            navbar.style.padding = "15px 0";
        }
    });

    const track = document.querySelector(".carrossel-track");
    const playPauseBtn = document.getElementById("play-pause-btn");
    let animationPaused = false;

    playPauseBtn.addEventListener("click", () => {
        if (animationPaused) {
            track.style.animationPlayState = "running";
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
            animationPaused = false;
        } else {
            track.style.animationPlayState = "paused";
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
            animationPaused = true;
        }
    });

    const modal = document.getElementById("dev-modal");
    const closeModal = document.getElementById("close-modal");
    const devButtons = document.querySelectorAll(".em-dev-btn");

    devButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const planName = this.closest(".em-desenvolvimento").querySelector(
                "h3"
            ).textContent;
            const contactBtn = document.getElementById("contact-btn");
            contactBtn.href = `mailto:argontechsolut@gmail.com?subject=${encodeURIComponent(
                window.translations.contact_us
            )}%20${encodeURIComponent(planName)}`;
            modal.style.display = "flex";
        });
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    const termsModal = document.getElementById("terms-modal");
    const closeTermsModal = document.getElementById("close-terms-modal");
    const modalTitle = document.getElementById("modal-title");
    const modalSubtitle = document.getElementById("modal-subtitle");
    const modalText = document.getElementById("modal-text");

    document
        .getElementById("terms-link")
        .addEventListener("click", function (e) {
            e.preventDefault();
            modalTitle.textContent = window.translations.terms_of_use;
            modalSubtitle.textContent = window.translations.last_update;
            termsModal.style.display = "block";
            document.body.style.overflow = "hidden";
        });

    document
        .getElementById("privacy-link")
        .addEventListener("click", function (e) {
            e.preventDefault();
            modalTitle.textContent = window.translations.privacy_policy;
            modalSubtitle.textContent = window.translations.last_update;
            modalText.innerHTML = window.translations.privacy_content;
            termsModal.style.display = "block";
            document.body.style.overflow = "hidden";
        });

    closeTermsModal.addEventListener("click", function () {
        termsModal.style.display = "none";
        document.body.style.overflow = "auto";
    });

    window.addEventListener("click", function (e) {
        if (e.target === termsModal) {
            termsModal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });
});
