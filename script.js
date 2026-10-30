"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.querySelector("#menuToggle");
  const navLinks = document.querySelector("#navLinks");
  if (menuToggle && navLinks) {
    menuToggle.addEventListener("click", () => {
      const open = navLinks.classList.toggle("open");
      menuToggle.setAttribute("aria-expanded", String(open));
    });
  }

  const themeToggle = document.querySelector("#themeToggle");
  const savedTheme = localStorage.getItem("studenthub-theme");
  if (savedTheme === "dark") document.body.classList.add("dark");
  if (themeToggle) {
    themeToggle.addEventListener("click", () => {
      document.body.classList.toggle("dark");
      localStorage.setItem("studenthub-theme", document.body.classList.contains("dark") ? "dark" : "light");
    });
  }

  const faqItems = document.querySelectorAll(".faq-list details");
  faqItems.forEach(item => item.addEventListener("toggle", () => {
    if (item.open) faqItems.forEach(other => { if (other !== item) other.open = false; });
  }));

  const registerForm = document.querySelector("#registerForm");
  if (registerForm) {
    const $ = id => document.getElementById(id);
    const setError = (id, message) => { const el = $(id); if (el) el.textContent = message; };
    const password = $("password"), confirm = $("confirmPassword");
    password.addEventListener("input", () => {
      const value = password.value;
      let score = 0;
      if (value.length >= 8) score++;
      if (/[A-Z]/.test(value)) score++;
      if (/[a-z]/.test(value)) score++;
      if (/[0-9]/.test(value)) score++;
      if (/[^A-Za-z0-9]/.test(value)) score++;
      $("passwordStrength").textContent = value ? `Password strength: ${["Very weak","Weak","Fair","Good","Strong","Strong"][score]}` : "Use 8+ characters with letters and numbers.";
    });
    registerForm.addEventListener("submit", event => {
      let valid = true;
      const name = $("fullName").value.trim();
      const email = $("email").value.trim();
      const mobile = $("mobile").value.trim();
      setError("nameError", name.length >= 2 ? "" : "Enter at least 2 characters."); valid &&= name.length >= 2;
      setError("emailError", /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) ? "" : "Enter a valid email address."); valid &&= /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
      setError("mobileError", /^[6-9]\d{9}$/.test(mobile) ? "" : "Enter a valid 10-digit Indian mobile number."); valid &&= /^[6-9]\d{9}$/.test(mobile);
      setError("courseError", $("course").value ? "" : "Choose a course."); valid &&= Boolean($("course").value);
      setError("passwordError", password.value.length >= 8 ? "" : "Use at least 8 characters."); valid &&= password.value.length >= 8;
      setError("confirmError", confirm.value === password.value ? "" : "Passwords do not match."); valid &&= confirm.value === password.value;
      setError("termsError", $("terms").checked ? "" : "Please accept the terms."); valid &&= $("terms").checked;
      if (!valid) { event.preventDefault(); $("registerMessage").textContent = "Please correct the highlighted fields."; }
    });
  }

  // Practical 13: Admin Event Management & Live Search (api_events.php sathe integration)
  const eventTableBody = document.querySelector("#eventTableBody");
  if (eventTableBody) {
    let allEvents = [];
    const searchBox = document.querySelector("#searchBox");

    const displayEvents = (events) => {
      eventTableBody.innerHTML = "";
      if (events.length > 0) {
        events.forEach(event => {
          let tr = document.createElement("tr");
          tr.innerHTML = `
            <td><img src="posters/${escapeHTML(event.poster_image)}" alt="Poster" width="60" style="border-radius: 4px;"></td>
            <td>${escapeHTML(event.title)}</td>
            <td>${escapeHTML(event.category)}</td>
            <td>${escapeHTML(event.event_date)}</td>
            <td>
                <a href="delete_event.php?id=${event.id}" class="btn" style="background: #dc3545;" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
            </td>
          `;
          eventTableBody.appendChild(tr);
        });
      } else {
        eventTableBody.innerHTML = `<tr><td colspan="5" style="text-align: center;">No matching events found.</td></tr>`;
      }
    };

    function escapeHTML(value) { 
      return String(value).replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c])); 
    }

    // api_events.php mathi async data fetch karvo
    fetch("api_events.php")
      .then(response => { 
        if (!response.ok) throw new Error("Could not load events."); 
        return response.json(); 
      })
      .then(result => { 
        if (result.status === "success") {
          allEvents = result.data;
          displayEvents(allEvents);
        } else {
          eventTableBody.innerHTML = `<tr><td colspan="5" style="text-align: center;">No events created yet.</td></tr>`;
        }
      })
      .catch(() => { 
        eventTableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: red;">Failed to load events.</td></tr>`; 
      });

    if (searchBox) {
      searchBox.addEventListener("input", () => {
        const query = searchBox.value.trim().toLowerCase();
        const filtered = allEvents.filter(event => 
          (event.title + " " + event.description + " " + event.category).toLowerCase().includes(query)
        );
        displayEvents(filtered);
      });
    }
  }
});
