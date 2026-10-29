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

  const eventList = document.querySelector("#eventList");
  if (eventList) {
    let events = [], currentPage = 1;
    const perPage = 6;
    const search = document.querySelector("#eventSearch");
    const category = document.querySelector("#eventCategory");
    const render = () => {
      const term = search.value.trim().toLowerCase();
      const type = category.value;
      const filtered = events.filter(e => (e.title + " " + e.description + " " + e.category).toLowerCase().includes(term) && (type === "all" || e.category === type));
      filtered.sort((a,b) => a.date.localeCompare(b.date));
      const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
      currentPage = Math.min(currentPage, totalPages);
      const shown = filtered.slice((currentPage-1)*perPage, currentPage*perPage);
      eventList.innerHTML = shown.length ? shown.map(e => `<article class="card event-card"><span class="pill">${escapeHTML(e.category)}</span><h3>${escapeHTML(e.title)}</h3><p>${escapeHTML(e.description)}</p><p class="event-meta">📅 ${escapeHTML(e.date)}</p></article>`).join("") : "<p>No events match your search.</p>";
      document.querySelector("#pageInfo").textContent = `Page ${currentPage} of ${totalPages}`;
      document.querySelector("#prevEvents").disabled = currentPage <= 1;
      document.querySelector("#nextEvents").disabled = currentPage >= totalPages;
    };
    function escapeHTML(value) { return String(value).replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c])); }
    fetch("data/events.json").then(response => { if (!response.ok) throw new Error("Could not load events."); return response.json(); })
      .then(data => { events = data; render(); })
      .catch(() => { eventList.innerHTML = "<p>Unable to load events. Start the project using a local server and try again.</p>"; });
    search.addEventListener("input", () => { currentPage=1; render(); });
    category.addEventListener("change", () => { currentPage=1; render(); });
    document.querySelector("#prevEvents").addEventListener("click", () => { currentPage--; render(); });
    document.querySelector("#nextEvents").addEventListener("click", () => { currentPage++; render(); });
  }
});
