// 1) Load Bootstrap’s JS (for collapse, dropdowns, etc.)
import * as bootstrap from "bootstrap";

// 2) Import your SCSS entry so Vite compiles it
import "../sass/app.scss";

// 3) Import Bootstrap Icons CSS
import "bootstrap-icons/font/bootstrap-icons.css";

// 4) Your own JS (e.g. Laravel Echo, Axios defaults…)
import axios from "axios";
window.axios = axios;

// 5) Optional: Password toggle from your login form
document.addEventListener("DOMContentLoaded", () => {
    const pwd = document.getElementById("password");
    const eye = document.getElementById("eyeIcon");
    if (pwd && eye) {
        eye.addEventListener("click", () => {
            const type = pwd.type === "password" ? "text" : "password";
            pwd.type = type;
            eye.classList.toggle("bi-eye");
            eye.classList.toggle("bi-eye-slash");
        });
    }
});
