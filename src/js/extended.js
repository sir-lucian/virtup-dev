function goToTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera

    const currentURL = window.location.href;
    const urlWithoutHash = currentURL.split("#")[0];
    window.history.replaceState({}, document.title, urlWithoutHash);
}

function isElementVisible(el) {
    var rect = el.getBoundingClientRect(),
        vWidth = window.innerWidth || document.documentElement.clientWidth,
        vHeight = window.innerHeight || document.documentElement.clientHeight,
        efp = function (x, y) {
            return document.elementFromPoint(x, y);
        };

    // Return false if it's not in the viewport
    if (
        rect.right < 0 ||
        rect.bottom < 0 ||
        rect.left > vWidth ||
        rect.top > vHeight
    )
        return false;

    // Return true if any of its four corners are visible
    return (
        el.contains(efp(rect.left, rect.top)) ||
        el.contains(efp(rect.right, rect.top)) ||
        el.contains(efp(rect.right, rect.bottom)) ||
        el.contains(efp(rect.left, rect.bottom))
    );
}
