const hideLogin = document.getElementById("hideLogin");
const hideSignup = document.getElementById("hideSignup");
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");

hideLogin.addEventListener('click', () => {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
});

hideSignup.addEventListener('click', () => {
    loginForm.style.display = "block";
    registerForm.style.display = "none";
});
