const salvar = document.getElementById("salvar")
const detalhes = document.getElementById("detalhes")
const propostas = document.getElementById("propostas")
const form = document.querySelector("form")
const errorMessage = document.getElementById("error-message")

// if (url.pathname.indexOf("/proposals") != -1) {
//     detalhes.href = `${url.origin}${url.pathname.replace("proposals", "details")}`
// } else if (url.pathname.indexOf("/details") != -1) {
//     propostas.href = `${url.origin}${url.pathname.replace("details", "proposals")}`
// }

function createMilestone() {
    
}

salvar.addEventListener("click", (e) => {
    let link = "http://127.0.0.1:5500"
    let src = String(salvar.src).replace(link, "")
    //alert(src)
    if (src == "/images/salvar.png") {
        salvar.src = "../images/salvar-filled.png"
    } else {
        salvar.src = "../images/salvar.png"
    }
})

form.addEventListener("submit", e => {
    e.preventDefault()
    let bidAmount = document.getElementById("bidAmount")
    let proposta = document.getElementById("proposta")
    let prazo = document.getElementById("prazo")
    let priceMilestone = document.getElementById("priceMilestone")
    
    if (bidAmount.value == "" || proposta.value == "" || prazo.value == "" || priceMilestone.value == "") {
        errorMessage.style.display = "block"
        errorMessage.innerHTML = "Campos vazios"
    } else if (proposta.value.length < 100) {
        errorMessage.style.display = "block"
        errorMessage.innerHTML = "Proposta menor que 100 caracteres"
    } else {
        e.currentTarget.submit()
    }
})

propostas.href = `${url.origin}${url.pathname}/../proposals`