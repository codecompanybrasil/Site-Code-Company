const url = new URL(String(window.location.href))

class DesignController {
    loginHeader(logged, avatar=undefined, id=undefined) {
        let nav = document.querySelector("nav.desktop-nav")
        let a = document.createElement("a")
        if (logged) {
            a.href = "/account"
            let img = document.createElement("img")
            img.setAttribute("id", "avatar")
            img.src = `https://cdn.discordapp.com/avatars/${id}/${avatar}`
            img.alt = "Avatar do discord"
            a.appendChild(img)
        } else {
            a.href = "https://discord.com/api/oauth2/authorize?client_id=1066492672182853642&redirect_uri=http%3A%2F%2F127.0.0.1%3A3000%2Fauth%2F&response_type=token&scope=identify"
            let button = document.createElement("button")
            button.setAttribute("class", "login-discord neon")
            let img = document.createElement("img")
            img.src= "/images/discord-icon.png"
            img.alt = "Discord Icon"
            button.appendChild(img)
            a.appendChild(button)
            let span = document.createElement("span")
            span.innerHTML = "Login"
            button.appendChild(span)
        }
        nav.appendChild(a)
    }

    loginUserHeader(avatar, id) {
        let header = document.querySelector("header")
        let img = document.createElement("img")
        img.setAttribute("class", "avatar")
        img.src = `https://cdn.discordapp.com/avatars/${id}/${avatar}`
        img.alt = "Avatar do discord"
        header.appendChild(img)
    }

    loginHeaderCelular(logged) {
        let menu = document.querySelector("div.menu-android")
        let a = document.createElement("a")
        if (logged) {
            a.href = "/account"
            a.setAttribute("class", "decoration-hover")
            a.innerHTML = "Minha Conta"
        } else {
            let button = document.createElement("button")
            button.setAttribute("class", "login-discord neon")
            let img = document.createElement("img")
            img.src = "/images/discord-icon.png"
            img.alt = "Discord Icon"
            let span = document.createElement("span")
            span.innerHTML = "Login"
            button.appendChild(img)
            button.appendChild(span)
            a.append(button)
        }
        menu.appendChild(a)
    }

    setProfileInformations(response) {
        let nome = document.getElementById("nome")
        nome.innerHTML = `${response.username}#${response.discriminator}`
        let id = document.getElementById("id")
        id.innerHTML = response.id
    }
}


function requiringDiscord(callback, cookie) {
    const fragment = new URLSearchParams(window.location.href.slice(1))
    var [accessToken, tokenType] = [fragment.get('access_token'), fragment.get('token_type')]
    if (accessToken == null) {
        accessToken = cookie
    }
    if (!accessToken && !cookie) {
        return false
    }
    fetch("https://discord.com/api/users/@me", {
        headers: {
            authorization: `Bearer ${accessToken}`
        }
    })
    .then(result => result.json())
    .then(response => callback(response))
    .catch(console.error)
}

function getCookies() {
    var savedCookies = {}
    var cookies = String(document.cookie).split(";")
    if (cookies == "") {
        return false
    }
    for (let c=0;c<cookies.length;c++) {
        let values = cookies[c].split("=")
        let name = values[0].replace(" ", "")
        let value = values[1]
        savedCookies[name] = value
    }
    return savedCookies
}