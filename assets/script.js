const btnMenuBurger = document.querySelector(".menu-burger");
const navMenu = document.querySelector(".menu-liste");

btnMenuBurger.addEventListener("click", () => {
  btnMenuBurger.classList.toggle("is-open");
  navMenu.classList.toggle("show");
});
