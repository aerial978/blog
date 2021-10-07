const navbtn = document.querySelector(".nav-btn");
const sidemenu = document.querySelector(".sidemenu");

navbtn.addEventListener("click", () => {
    navbtn.classList.toggle("active");
    sidemenu.classList.toggle("active");
})

document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
    navbtn.classList.remove("active");
    sidemenu.classList.remove("active");
}))




