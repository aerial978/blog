const navbtn = document.querySelector(".nav-btn");
const sidemenu = document.querySelector(".sidemenu");
const closebtn = document.querySelector(".close-btn");

navbtn.addEventListener("click", () => {
    navbtn.classList.toggle("active");
    sidemenu.classList.toggle("active");
})

closebtn.addEventListener("click", () => {
    sidemenu.classList.toggle("active");
})

document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
    navbtn.classList.remove("active");
    sidemenu.classList.remove("active");
}))

document.querySelectorAll(".close-btn").forEach(n => n.addEventListener("click", () => {
    navbtn.classList.remove("active");
}));







