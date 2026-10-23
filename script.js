document.addEventListener("DOMContentLoaded", () => {
    // 1. Notification Banner
    if (!document.querySelector(".notice-banner")) {
        const banner = document.createElement("div");
        banner.className = "notice-banner";
        banner.innerHTML = `<span>Welcome to StudentHub! Explore your student services.</span><button class="notice-close">✕</button>`;
        document.body.prepend(banner);
        banner.querySelector(".notice-close").addEventListener("click", () => banner.remove());
    }

    
    // 2. Dark/Light Mode Switcher with localStorage
    let themeBtn = document.getElementById("theme-toggle");
    if (!themeBtn) {
        themeBtn = document.createElement("button");
        themeBtn.id = "theme-toggle";
        document.body.appendChild(themeBtn);
    }
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        document.body.classList.add("dark-theme");
        themeBtn.innerHTML = "☀️ Light Mode";
    } else {
        themeBtn.innerHTML = "🌙 Dark Mode";
    }
    themeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-theme");
        const isDark = document.body.classList.contains("dark-theme");
        localStorage.setItem("theme", isDark ? "dark" : "light");
        themeBtn.innerHTML = isDark ? "☀️ Light Mode" : "🌙 Dark Mode";

    });

    // 3. Hamburger Menu Toggle
    const nav = document.querySelector("nav");
    if (nav && !document.querySelector(".hamburger")) {
        const hamburger = document.createElement("button");
        hamburger.className = "hamburger";
        hamburger.innerHTML = "☰";
        nav.before(hamburger);
        hamburger.addEventListener("click", () => nav.classList.toggle("active"));
    }

    // 4. Collapsible FAQ Interaction
    document.querySelectorAll(".faq-box").forEach(box => {
        const p = box.querySelector("p");
        if (p) {
            p.className = "faq-answer";
            box.addEventListener("click", () => box.classList.toggle("active"));
        }
    });

    // 5. Modal Popup Trigger (Auto opens on Home/Index or via trigger)
    if (!document.querySelector(".modal-overlay")) {
        const modal = document.createElement("div");
        modal.className = "modal-overlay";
        modal.innerHTML = `
            <div class="modal-content">
                <h3>Announcement</h3>
                <p>Don't forget to register for the upcoming Hackathon!</p>
                <button id="close-modal" style="margin-top:15px; padding:8px 15px; background:var(--primary); color:#fff; border:none; border-radius:5px; cursor:pointer;">Got It</button>
            </div>`;
        document.body.appendChild(modal);
        setTimeout(() => modal.classList.add("open"), 1500); // Popup after 1.5s
        modal.querySelector("#close-modal").addEventListener("click", () => modal.classList.remove("open"));
    }

    // 6. Content Slider
    const sliderContainer = document.querySelector(".slider-container");
    if (sliderContainer) {
        let slideIndex = 0;
        const slides = sliderContainer.querySelectorAll(".slide");
        function showSlides() {
            slides.forEach(s => s.classList.remove("active"));
            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].classList.add("active");
            setTimeout(showSlides, 4000);
        }
        if (slides.length > 0) { slides[0].classList.add("active"); setTimeout(showSlides, 4000); }
    }
});