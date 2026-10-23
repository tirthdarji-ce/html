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

   document.addEventListener("DOMContentLoaded", () => {
    // 1. Notification Banner
    if (!document.querySelector(".notice-banner")) {
        const banner = document.createElement("div");
        banner.className = "notice-banner";
        banner.innerHTML = `<span>Welcome to StudentHub! Explore your student services.</span><button class="notice-close">✕</button>`;
        document.body.prepend(banner);
        banner.querySelector(".notice-close").addEventListener("click", () => banner.remove());
    }

     // 4. Registration Form Validation & Submission

    const registrationForm = document.getElementById("registrationForm");
    if (registrationForm) {
        registrationForm.addEventListener("submit", function(event) {
            event.preventDefault();

            // Clear previous errors
            document.querySelectorAll(".error").forEach(function(error) {
                error.innerHTML = "";
            });

            const successEl = document.getElementById("success");
            if (successEl) successEl.innerHTML = "";

            let valid = true;

            // Get values
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let mobile = document.getElementById("mobile").value.trim();
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirmPassword").value;
            let course = document.getElementById("course").value;
            let year = document.getElementById("year").value;
            let gender = document.querySelector('input[name="gender"]:checked');
            let terms = document.getElementById("terms").checked;

            // Regular Expressions
            let namePattern = /^[A-Za-z ]{3,}$/;
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let mobilePattern = /^[6-9][0-9]{9}$/;
            let passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@#$!]).{8,}$/;

            // Validations
            if (!namePattern.test(name)) {
                document.getElementById("nameError").innerHTML = "Enter a valid name.";
                valid = false;
            }

            if (!emailPattern.test(email)) {
                document.getElementById("emailError").innerHTML = "Enter a valid email.";
                valid = false;
            }

            if (!mobilePattern.test(mobile)) {
                document.getElementById("mobileError").innerHTML = "Enter a valid 10-digit mobile number.";
                valid = false;
            }

            if (!passwordPattern.test(password)) {
                document.getElementById("passwordError").innerHTML = "Password must contain 8 characters, uppercase, lowercase, number and special character.";
                valid = false;
            }

            if (password !== confirmPassword) {
                document.getElementById("confirmError").innerHTML = "Passwords do not match.";
                valid = false;
            }

            if (course === "") {
                document.getElementById("courseError").innerHTML = "Please select a course.";
                valid = false;
            }

            if (year === "") {
                document.getElementById("yearError").innerHTML = "Please select your year.";
                valid = false;
            }

            if (!gender) {
                document.getElementById("genderError").innerHTML = "Please select your gender.";
                valid = false;
            }

            if (!terms) {
                document.getElementById("termsError").innerHTML = "Please accept the terms and conditions.";
                valid = false;
            }

            if (valid && successEl) {
                successEl.innerHTML = "Registration successful!";
            }
        });
    }

    // 5. Password Strength Meter
    const passwordInput = document.getElementById("password");
    if (passwordInput) {
        passwordInput.addEventListener("input", function() {
            let password = this.value;
            let strength = document.getElementById("strength");
            if (!strength) return;

            if (password.length === 0) {
                strength.innerHTML = "";
            } else if (password.length < 6) {
                strength.innerHTML = "Weak";
            } else if (password.length < 8) {
                strength.innerHTML = "Medium";
            } else {
                strength.innerHTML = "Strong";
            }
        });
    }
});
let allEventsData = { technical: [], nonTechnical: [] };

document.addEventListener("DOMContentLoaded", () => {
    fetch('event.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load event data');
            }
            return response.json();
        })
        .then(responseJson => {
            // Parses the nested "events" object from your JSON structure[cite: 5]
            const eventsObj = responseJson.events || responseJson;
            allEventsData = {
                technical: eventsObj.technical || [],
                nonTechnical: eventsObj.non_technical || eventsObj.nonTechnical || []
            };
            renderEvents(allEventsData);
            setupSearchAndFilter();
        })
        .catch(error => {
            console.error('Error fetching events:', error);
        });
});

function renderEvents(data) {
    renderEventsBySection(0, data.technical, 'technical');
    renderEventsBySection(1, data.nonTechnical, 'non-technical');
}

function renderEventsBySection(sectionIndex, eventsArray, categoryKey) {
    const eventSections = document.querySelectorAll('.event-section');
    if (!eventSections[sectionIndex]) return;

    const container = eventSections[sectionIndex].querySelector('.events');
    if (!container) return;

    container.innerHTML = '';

    if (eventsArray.length === 0) {
        container.innerHTML = '<p class="no-events" style="color: #666; grid-column: 1 / -1;">No matching events found.</p>';
        return;
    }

    eventsArray.forEach(event => {
        const card = document.createElement('div');
        card.className = 'event-card';

        card.innerHTML = `
            <h3>${event.title}</h3>
            <p>${event.description}</p>
            <span>📅 Date: ${event.date}</span>
        `;

        container.appendChild(card);
    });
}

function setupSearchAndFilter() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const eventSections = document.querySelectorAll('.event-section');

    if (!searchInput || !categoryFilter) return;

    function filterAndRender() {
        const query = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value; // 'all', 'technical', 'non-technical'

        // Helper to match text while ignoring emojis/symbols
        const matchesQuery = (text) => {
            const cleanText = text.replace(/[\u{1F000}-\u{1F9FF}]/gu, "").toLowerCase();
            return cleanText.includes(query) || text.toLowerCase().includes(query);
        };

        const filteredTechnical = allEventsData.technical.filter(event => {
            const matchesSearch = matchesQuery(event.title) || matchesQuery(event.description);
            const matchesCategory = selectedCategory === 'all' || selectedCategory === 'technical';
            return matchesSearch && matchesCategory;
        });

        const filteredNonTechnical = allEventsData.nonTechnical.filter(event => {
            const matchesSearch = matchesQuery(event.title) || matchesQuery(event.description);
            const matchesCategory = selectedCategory === 'all' || selectedCategory === 'non-technical';
            return matchesSearch && matchesCategory;
        });

        renderEventsBySection(0, filteredTechnical, 'technical');
        renderEventsBySection(1, filteredNonTechnical, 'non-technical');

        if (eventSections[0] && eventSections[1]) {
            eventSections[0].style.display = (selectedCategory !== 'all' && selectedCategory !== 'technical') ? 'none' : 'block';
            eventSections[1].style.display = (selectedCategory !== 'all' && selectedCategory !== 'non-technical') ? 'none' : 'block';
        }
    }

    searchInput.addEventListener('input', filterAndRender);
    categoryFilter.addEventListener('change', filterAndRender);
}