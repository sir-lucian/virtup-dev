function toggleMobileNav() {
    const hideMenu = "hideMenu";
    const showMenu = "showMenu";
    const mobileMenu = document.getElementById("mobileNav");
    const hamburgerDiv = document.getElementById("hamburger_menu");
    const hamburgerButton = '<i class="bi bi-list text-white"></i>';
    const closeButton = '<i class="bi bi-x-lg text-white"></i>';
    mobileMenu.classList.toggle(hideMenu);
    mobileMenu.classList.toggle(showMenu);
    if (mobileMenu.classList.contains(showMenu) && !mobileMenu.classList.contains(hideMenu)) {
        hamburgerDiv.innerHTML = closeButton;
        hamburgerDiv.style.transform = 'rotate(90deg)';
        mobileMenu.style.height = 'auto';
    } else {
        hamburgerDiv.innerHTML = hamburgerButton;
        hamburgerDiv.style.transform = 'rotate(0deg)';
        mobileMenu.style.height = '0px';
    }
}

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}
