async function toggleMobileNav() {
    const mobileMenu = document.getElementById("mobileNav");
    mobileMenu.classList.toggle("hideMenu");
    mobileMenu.classList.toggle("showMenu");
}

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}
