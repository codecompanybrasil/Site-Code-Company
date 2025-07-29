const arrowDown = document.querySelector("div.arrow-down")
const botaoMenu = document.getElementById("android-menu")
const menu = document.querySelector(".menu-android")

// let design = new DesignController()
// design.loginHeaderCelular(false)
// design.loginHeader(false)


document.body.addEventListener("scroll", (e) => {
    if (document.body.scrollTop == 0) {
        arrowDown.setAttribute("style", "visibility: visible")
    } else {
        arrowDown.setAttribute("style", "opacity: 0%")
    }
})

arrowDown.addEventListener("click", (e) => {
    document.body.scroll(0, 700)
})

botaoMenu.addEventListener("click", (e) => {
    let { opacity } = getComputedStyle(menu)
    if (opacity == 0) {
        menu.setAttribute("style", "opacity: 100%")
    } else {
        menu.setAttribute("style", "opacity: 0%")
    }
})