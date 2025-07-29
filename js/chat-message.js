const emoji = document.getElementById("emoji")
const emojiMenu = document.getElementById("emoji-menu")
const send = document.getElementById("send")
const inbox = document.getElementById("inbox")
const messages = document.querySelectorAll("div.message")
var imgMessages = document.querySelectorAll("a.message-image-file")
const imgPopUp = document.querySelector("#img-pop-up")
const popUp = document.querySelector(".pop-up")
const closePopUp = document.getElementById("close-pop-up")
const sender = document.getElementById("input-sender")
var closeResponseArea = document.getElementById("close-response-area")
const responseArea = document.querySelector("#response-area")
const attachmentArea = document.getElementById("attachment-area")
const emojis = document.querySelectorAll("span.emoji")
const menuUser = document.getElementById("user-menu-button")
const fileMessage = document.getElementById("file-message")
var replyArea = document.querySelectorAll(".reply-area")
const senderArea = document.querySelector(".sender-area")
const endResponse = document.getElementById("end-response")
const userMenu = document.getElementById("user-menu")
const titleHeader = document.getElementById("title-header")
const contactsSection = document.querySelector("#contacts-section-phone")
const contactButtonPhone = document.getElementById("contact-button-phone")
const closeContactPhone = document.getElementById("close-contact-phone")
const popUpDownload = document.getElementById("pop-up-download")

var attachmentOptions = {
    "type": "",
    "name": "",
    "src": ""
}

emoji.addEventListener("click", (e) => {
    let { display } = getComputedStyle(emojiMenu)
    if (display == "none") {
        emojiMenu.style.display = "flex"
    } else {
        emojiMenu.style.display = "none"
    }
})

function checkDate() { //Checkando se é necessário a listra de dia
    let lastHorario = document.querySelectorAll(".horario")
    lastHorario = lastHorario[lastHorario.length - 1]
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function getDate() {
    let date = new Date()
    let hours = date.getHours()
    let minutos = date.getMinutes()
    let ampm = hours >= 12 ? "PM" : "AM"
    hours = hours % 12 ? hours % 12 : 12
    minutos = minutos < 10 ? `0${minutos}` : minutos
    return `${hours}:${minutos} ${ampm}`
}

function checkPicture() {
    let lastMessage = document.querySelectorAll(".message-area")
    if (lastMessage == undefined || lastMessage == null) {
        return true
    } 
    lastMessage = lastMessage[lastMessage.length - 1]
    let lastHour = document.querySelectorAll(".horario")
    lastHour = lastHour[lastHour.length - 1]
    let time = getDate().toLowerCase()
    let hour = Number(time.split(":")[0])
    let minutos = time.split(":")[1]
    minutos = minutos.replace("am", "")
    minutos = minutos.replace("pm", "")
    minutos = Number(minutos.replace(" ", ""))
    if (lastMessage.className.indexOf("client-message") != -1) {
        return true
    }

    if (checkMinutes(lastHour.innerHTML, hour, minutos)) {
        return true
    }

    return false
}

function checkMinutes(time, newHour, newMinute) {//|
    time = String(time).toLowerCase()
    let hour = Number(time.split(":")[0])
    let minutos = time.split(":")[1]
    minutos = minutos.replace("am", "")
    minutos = minutos.replace("pm", "")
    minutos = Number(minutos.replace(" ", ""))
    if (hour < newHour || (newMinute - minutos) >= 10) {
        return true
    }
    return false
}

function sendMessage() {
    let lastHour = document.querySelectorAll("horario")
    lastHour = lastHour[lastHour.length - 1]

    let messageDiv = document.createElement("div")
    messageDiv.classList.add("message")
    let messageArea = document.createElement("div")
    messageArea.classList.add("message-area")
    messageArea.classList.add("user-message")
    let replyArea = document.createElement("div")
    replyArea.classList.add("reply-area")
    let imgReply = document.createElement("img")
    imgReply.src = "images/reply.png"
    imgReply.alt = "Reply Icon"
    let messageContentArea = document.createElement("div")
    messageContentArea.classList.add("message-content-area")
    let messageContent = document.createElement("div")
    messageContent.classList.add("message-content")
    let horario = document.createElement("div")
    horario.classList.add("horario")
    horario.innerHTML = getDate()
    let checkMessage = document.createElement("div")
    checkMessage.classList.add("check-message")
    let imgStatus = document.createElement("img")
    imgStatus.src = "images/square-clock.png"
    imgStatus.alt = "Icon que mostra se a mensagem foi entregue e/ou lida"
    let picture = document.createElement("div")
    picture.classList.add("picture")
    picture.setAttribute("style", "position: relative")
    checkMessage.appendChild(imgStatus)

    if (getComputedStyle(responseArea).display != "none") { //Resposta
        let response = document.getElementById("response-content-text")
        let closeResponseArea = document.getElementById("close-response-area")
        let title = document.getElementById("title-response")
        let messageResponse = document.createElement("div")
        messageResponse.classList.add("message-response")
        let titleResponse = document.createElement("div")
        titleResponse.classList.add("title-response")
        titleResponse.innerHTML = title.innerHTML
        let contentResponse = document.createElement("div")
        contentResponse.classList.add("content-response")
        if (response.className.indexOf("response-filename") != -1) {
            contentResponse.classList.add("content-response-file")
        }
        contentResponse.innerHTML = response.innerHTML
        messageResponse.appendChild(titleResponse)
        messageResponse.appendChild(contentResponse)
        messageContentArea.appendChild(messageResponse)
        closeResponseArea.click()
    }

    if (getComputedStyle(attachmentArea).display != "none") { //Arquivo
        var file = document.getElementById("file-message")
        if (attachmentOptions["type"] == "file") {
            let messageFile = document.createElement("a")
            messageFile.href = "#"
            messageFile.classList.add("message-file")
            let imgFile = document.createElement("img")
            imgFile.src = "images/file-icon.png"
            imgFile.alt = "Icon de arquivo para download"
            let span = document.createElement("span")
            span.innerHTML = htmlEntities(attachmentOptions["name"])
            let d1 = document.createElement("div")
            d1.setAttribute("style", "display: flex;align-self: flex-end;")
            replyArea.appendChild(imgReply)
            d1.appendChild(horario)
            d1.appendChild(checkMessage)
            messageFile.appendChild(imgFile)
            messageFile.appendChild(span)
            messageContent.appendChild(messageFile)
            messageContent.appendChild(d1)
            messageContentArea.appendChild(messageContent)
            messageArea.appendChild(replyArea)
            messageArea.appendChild(messageContentArea)
            messageArea.appendChild(picture)
        } else if (attachmentOptions["type"] == "img") { //Imagem
            messageContent.classList.add("message-image-file")
            let imageFile = document.createElement("a")
            imageFile.classList.add("message-image-file")
            imageFile.href = "#"
            let i = document.createElement("img")
            i.src = attachmentOptions["src"]
            i.alt = "Imagem enviada na inbox"
            let d = document.createElement("div")
            let span = document.createElement("span")
            span.innerHTML = attachmentOptions["name"]
            let d1 = document.createElement("div")
            d1.setAttribute("style", "display: flex;align-self: flex-end;")
            replyArea.appendChild(imgReply)
            d1.appendChild(horario)
            d1.appendChild(checkMessage)
            d.appendChild(span)
            d.appendChild(d1)
            imageFile.appendChild(i)
            imageFile.appendChild(d)
            messageContent.appendChild(imageFile)
            messageContentArea.appendChild(messageContent)
            messageArea.appendChild(replyArea)
            messageArea.appendChild(messageContentArea)
            messageArea.appendChild(picture)
            imageFile.children[0].addEventListener("click", (e) => {
                imgPopUp.src = imageFile.children[0].src
                popUpDownload.href = attachmentOptions["src"]
                popUp.style.display = "flex"
            })
        }
        document.getElementById("close-response-attachment").click()
    } else {
        if (sender.value == "") {
            return false
        }
        let span = document.createElement("span")
        span.innerHTML = htmlEntities(sender.value)
        let d1 = document.createElement("div")
        d1.setAttribute("style", "display: flex;align-self: flex-end;")
        replyArea.appendChild(imgReply)
        d1.appendChild(horario)
        d1.appendChild(checkMessage)
        messageContent.appendChild(span)
        messageContent.appendChild(d1)
        messageContentArea.appendChild(messageContent)
        if (checkPicture()) {
            let i = document.createElement("img")
            i.src = "images/logo_marca_branca.png"
            i.alt = "Logo do usuário Code Company"
            picture.appendChild(i)
        }
        messageArea.appendChild(replyArea)
        messageArea.appendChild(messageContentArea)
        messageArea.appendChild(picture)
        setTimeout(e => {
            sender.value = ""
        }, 50)
        inbox.scroll(0, inbox.scrollHeight)
    }
    replyArea.addEventListener("click", (e) => {
        let messageContent = getMessageContent(replyArea.parentNode)
        reply(messageContent)
    })
    messageDiv.appendChild(messageArea)
    inbox.appendChild(messageDiv)
    messageDiv.addEventListener("mouseover", (e) => {
        //reply-area
        if (messageDiv.children[0].children[0].className == "reply-area") {
            messageDiv.children[0].children[0].style.display = "flex"
        } else {
            messageDiv.children[0].children[2].style.display = "flex"
        }
    })

    messageDiv.addEventListener("mouseout", (e) => {
        if (messageDiv.children[0].children[0].className == "reply-area") {
            messageDiv.children[0].children[0].style.display = "none"
        } else {
            messageDiv.children[0].children[2].style.display = "none"
        }
    })
    sender.value = ""
    inbox.scroll(0, inbox.scrollHeight)
}

function getMessageContent(divMessage) {
    for (let i=0;i<divMessage.children.length;i++) {
        let child = divMessage.children[i]
        // console.log(child.className)
        if (String(child.className).indexOf("message-content") != -1) {
            return child
        }
    }
}

function createAttachment(src, nameImg, type) {
    attachmentArea.innerHTML = ""
    let startAttachment = document.createElement("div")
    startAttachment.setAttribute("class", "start-attachment")
    let img = document.createElement("img")
    img.alt = "Imagem dentro do reply"
    if (type == "img") {
        img.src = src
    } else if (type == "file") {
        img.src = "images/file-icon.png"
        img.setAttribute("style", "max-width: 70px")
    }
    img.setAttribute("class", "img-response")
    let attachmentContent = document.createElement("div")
    attachmentContent.setAttribute("class", "attachment-content")
    let spanName = document.createElement("span")
    spanName.setAttribute("class", "response-filename")
    spanName.innerHTML = nameImg
    let span = document.createElement("span")
    span.innerHTML = "Attachment"
    let endAttachment = document.createElement("div")
    endAttachment.setAttribute("id", "end-attachment")
    let close = document.createElement("img")
    close.setAttribute("class", "close")
    close.setAttribute("id", "close-response-attachment")
    close.src = "images/simple-close.png"
    close.alt = "Icon para fechar o response"
    close.addEventListener("click", e => {
        attachmentArea.style.display = "none"
        fileMessage.value = ""
        fileMessage.innerHTML = ""
        sender.removeAttribute("disabled")
    })
    startAttachment.appendChild(img)
    startAttachment.appendChild(attachmentContent)
    attachmentContent.appendChild(spanName)
    attachmentContent.appendChild(span)
    endAttachment.appendChild(close)
    attachmentArea.appendChild(startAttachment)
    attachmentArea.appendChild(endAttachment)
    attachmentArea.setAttribute("style", "display: flex;")
    sender.setAttribute("disabled", "true")
    document.getElementById("files").blur()

    //attachmentArea.appendChild()
}


function reply(messageContent) {
    responseArea.style.display = "flex"
    //alert(endResponse.children.length)
    // for (let i=0;i<endResponse.children.length;i++) {
    //     endResponse.removeChild(endResponse.children[i])
    // }
    // if (endResponse.children.length) {
    //     endResponse.removeChild(endResponse.children[0])
    // }
    endResponse.innerHTML = ""

    if (String(messageContent.children[0].className).indexOf("message-response") != -1) {
        messageContent = messageContent.children[1]
    } else {
        messageContent = messageContent.children[0]
    }

    //console.log(messageContent)
    var message = messageContent.parentNode.parentNode
    responseArea.children[0].removeChild(responseArea.children[0].children[0])
    console.log(message)
    if (String(message.className).indexOf("user-message") != -1) { //Mensagem propria
        let p = document.createElement("p")
        let span = document.createElement("span")
        span.setAttribute("class", "title-header-contact")
        span.setAttribute("id", "title-response")
        span.innerHTML = "Você"
        p.appendChild(span)
        responseArea.children[0].insertAdjacentElement("afterbegin", p)
    } else {
        let p = document.createElement("p")
        let span = document.createElement("span")
        span.setAttribute("class", "title-header-contact")
        span.setAttribute("id", "title-response")
        span.innerHTML = String(titleHeader.innerHTML).replace(" ", "")
        p.appendChild(span)
        responseArea.children[0].insertAdjacentElement("afterbegin", p)
    }

    if (String(messageContent.className).indexOf("message-image-file") != -1) { //Imagem
        let img = document.createElement("img")
        img.src = messageContent.children[0].children[0].src
        img.alt = "Imagem dentro do reply"
        img.setAttribute("class", "img-response")
        responseArea.children[1].insertAdjacentElement("afterbegin", img)
        let a = document.createElement("a")
        a.setAttribute("class", "response-filename")
        a.setAttribute("id", "response-content-text")
        a.href = "#"
        a.innerHTML = messageContent.children[0].children[1].children[0].innerHTML
        responseArea.children[0].removeChild(responseArea.children[0].children[1])
        responseArea.children[0].appendChild(a)
    } else if (String(messageContent.children[0].className).indexOf("message-file") != -1) {
        let img = document.createElement("img")
        img.src = "images/file-icon.png"
        img.alt = "Icon de arquivo para download"
        responseArea.children[1].insertAdjacentElement("afterbegin", img)
        let a = document.createElement("a")
        a.setAttribute("class", "response-filename")
        a.setAttribute("id", "response-content-text")
        a.href = "#"
        a.innerHTML = messageContent.children[0].children[1].innerHTML
        responseArea.children[0].removeChild(responseArea.children[0].children[1])
        responseArea.children[0].appendChild(a)
    } else {
        let p = document.createElement("p")
        p.setAttribute("class", "last-message")
        p.setAttribute("id", "response-content-text")
        //console.log(String(messageContent.children[0].innerHTML).length)
        if (String(messageContent.children[0].innerHTML).length > 20) {
            p.innerHTML = String(messageContent.children[0].innerHTML).substring(0, 19) + " ..."
        } else {
            p.innerHTML = messageContent.children[0].innerHTML
        }
        responseArea.children[0].removeChild(responseArea.children[0].children[1])
        responseArea.children[0].appendChild(p)
    }

    let close = document.createElement("img")
    close.src = "images/simple-close.png"
    close.alt = "Icon para fechar o respons"
    close.setAttribute("id", "close-response-area")
    close.setAttribute("class", "close")
    close.addEventListener("click", (e) => [
        responseArea.style.display = "none"
    ])
    endResponse.appendChild(close)

}

for (let i=0;i<messages.length;i++) {
    messages[i].addEventListener("mouseover", (e) => {
        //reply-area
        if (messages[i].children[0].children[0].className == "reply-area") {
            messages[i].children[0].children[0].style.display = "flex"
        } else {
            messages[i].children[0].children[2].style.display = "flex"
        }
    })

    messages[i].addEventListener("mouseout", (e) => {
        if (messages[i].children[0].children[0].className == "reply-area") {
            messages[i].children[0].children[0].style.display = "none"
        } else {
            messages[i].children[0].children[2].style.display = "none"
        }
    })
}

for (let i=0;i<imgMessages.length;i++) {
    imgMessages[i].children[0].addEventListener("click", (e) => {
        //alert(1)
        let src = imgMessages[i].children[0].src
        imgPopUp.src = imgMessages[i].children[0].src
        popUp.style.display = "flex"
    })
}

function refreshReplyEvent() {
    for (let i=0;i<replyArea.length;i++) {
        replyArea[i].addEventListener("click", (e) => {
            let messageContent = getMessageContent(replyArea[i].parentNode)
            reply(messageContent)
    
        })
    }
}

for (let i=0;i<emojis.length;i++) {
    emojis[i].addEventListener("click", e => {
        sender.value += emojis[i].innerHTML
    })
}

// closePopUp.addEventListener("click", (e) => {
//     popUp.style.display = "none"
// })

window.addEventListener("resize", (event) => {
    let { display } = getComputedStyle(contactsSection)
    if (display != "none") {
        window.location.reload()
    }
})

window.addEventListener("keypress", event => {
    let key = event.keyCode
    if (key == 13) {
        sendMessage()
    }
})

sender.addEventListener("keyup", e=> {
    if (sender.value == "\n") {
        sender.value = ""
    }
})

window.addEventListener("load", e => {
    refreshReplyEvent()
})

send.addEventListener("click", e => {
    sendMessage()
})

popUp.addEventListener("click", (e) => {
    if (popUp.style.display == "flex") {
        popUp.style.display = "none"
    }
})

contactButtonPhone.addEventListener("click", e => {
    let { display } = getComputedStyle(contactsSection)
    if (display == "none") {
        contactsSection.style.display = "flex"
    } else {
        contactsSection.style.display = "none"
    }
})

closeContactPhone.addEventListener("click", e => {
    contactsSection.style.display = "none"
})

fileMessage.addEventListener("change", e => {
    if (fileMessage.value) {
        let reader = new FileReader()
        let nameFileInput = String(fileMessage.value).split("\\")
        let type = ""
        let typePerm = ["png", "jpg", "jpeg", "gif", "jpe", "jfif", "tiff", "tif", "webp"]
        nameFileInput = nameFileInput[nameFileInput.length-1]
        
        let ext = nameFileInput.split(".")
        ext = ext[ext.length-1]
        
        if (typePerm.indexOf(ext) != -1) {
            type = "img"
        } else {
            type = "file"
        }

        attachmentOptions["name"] = nameFileInput
        attachmentOptions["type"] = type
        reader.addEventListener("load", e => {
            attachmentOptions["src"] = e.target.result
            createAttachment(e.target.result, htmlEntities(nameFileInput), type)

        })

        reader.readAsDataURL(e.target.files[0])
    }
})
 