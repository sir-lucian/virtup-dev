async function getHomeDetails() {
    const homeResponse = await fetch("src/json/home.json");
    const homeDetails = await homeResponse.json();

    if (homeDetails.data) {
        const data = homeDetails.data;
        const aboutDetails =
            data[data.findIndex((section) => section.section === "about")] ??
            undefined;
        const contactDetails =
            data[data.findIndex((section) => section.section === "contact")] ??
            undefined;

        if (aboutDetails) {
            const menuLogo = document.getElementById("menu-logo");
            const aboutLogo = document.getElementById("about-logo");
            aboutLogo.src = aboutDetails.details.logo.path ?? "";
            aboutLogo.alt = aboutDetails.details.logo.alt ?? "";
            menuLogo.src = aboutDetails.details.logo.path ?? "";
            menuLogo.alt = aboutDetails.details.logo.alt ?? "";
            const aboutTitle = document.getElementById("about-title");
            aboutTitle.innerText = aboutDetails.details.title ?? "";
            const aboutSubtitle = document.getElementById("about-subtitle");
            aboutSubtitle.innerText = aboutDetails.details.subtitle ?? "";
            const aboutDescription =
                document.getElementById("about-description");
            aboutDescription.innerText = aboutDetails.details.description ?? "";
        }

        if (contactDetails) {
            const contactTitle = document.getElementById("contact-title");
            contactTitle.innerText = contactDetails.details.title ?? "";
            const contactSubtitle = document.getElementById("contact-subtitle");
            contactSubtitle.innerText = contactDetails.details.subtitle ?? "";
            const contactAddress = document.getElementById("contact-address");
            contactAddress.innerText = contactDetails.details.address ?? "";
            const contactEmail = document.getElementById("contact-email");
            contactEmail.innerText = contactDetails.details.email ?? "";
            const contactPhone = document.getElementById("contact-phone");
            contactPhone.innerText = contactDetails.details.phone ?? "";
            const contactPhoneName =
                document.getElementById("contact-phone-name");
            contactPhoneName.innerText =
                contactDetails.details.phone_name ?? "";
            const socialFacebook = document.getElementById("social-facebook");
            socialFacebook.href = contactDetails.details.social.facebook ?? "";
            const socialX = document.getElementById("social-x");
            socialX.href = contactDetails.details.social.x ?? "";
            const socialYoutube = document.getElementById("social-youtube");
            socialYoutube.href = contactDetails.details.social.youtube ?? "";
        }
    }
}
