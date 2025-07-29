//Proibido jobs com tags: IP Agreement, NDA e temporariamente Tecnical co pilot

//Fazer um div que aparece no hover explicando cada tag desses ai de cima (as que podem claro)


var searchFilter = document.getElementById("search-filter")
const search = document.getElementById("search")
const backPage = document.getElementById("back-page")
const nextPage = document.getElementById("next-page")
var fixedPrice = document.getElementById("fixed-price")
var hourlyRate = document.getElementById("hourly-rate")
var minFPrice = document.getElementById("min-fixed-price")
var maxFPrice = document.getElementById("max-fixed-price")
var minHPrice = document.getElementById("min-hourly-price")
var maxHPrice = document.getElementById("max-hourly-price")
var brLang = document.getElementById("br-lang")
var enLang = document.getElementById("en-lang")
var clearTypeProject = document.getElementById("clear-type-project")
var clearFixedPrice = document.getElementById("clear-fixed-price")
var clearHourlyPrice = document.getElementById("clear-hourly-price")
var clearLinguagem = document.getElementById("clear-linguagem")
var numbers = document.querySelectorAll(".number-select")

function clickFilterArea(){
    let hiddenFilterArea = document.querySelector(".hidden-filter-area")
    if (hiddenFilterArea.style.display == "none") {
        hiddenFilterArea.style.display = "flex"
    } else {
        hiddenFilterArea.style.display = "none"
    }
}

function filterReset() {
    fixedPrice = document.getElementById("fixed-price")
    hourlyRate = document.getElementById("hourly-rate")
    minFPrice = document.getElementById("min-fixed-price")
    maxFPrice = document.getElementById("max-fixed-price")
    minHPrice = document.getElementById("min-hourly-price")
    maxHPrice = document.getElementById("max-hourly-price")
    brLang = document.getElementById("br-lang")
    enLang = document.getElementById("en-lang")
    clearTypeProject = document.getElementById("clear-type-project")
    clearFixedPrice = document.getElementById("clear-fixed-price")
    clearHourlyPrice = document.getElementById("clear-hourly-price")
    clearLinguagem = document.getElementById("clear-linguagem")
    console.log(clearTypeProject)
    document.getElementById("search-filter").addEventListener("click", e => {
        searchActive()
    })
    clearTypeProject.addEventListener("click", e => {
        fixedPrice.checked = false
        hourlyRate.checked = false
    })
    
    clearFixedPrice.addEventListener("click", e => {
        minFPrice.value = ""
        maxFPrice.value = ""
    })
    
    clearHourlyPrice.addEventListener("click", e => {
        minHPrice.value = ""
        maxHPrice.value = ""
    })
    
    clearLinguagem.addEventListener("click", e => {
        brLang.checked = false
        enLang.checked = false
    })
}

function searchActive() {
    let searchUrl = new URL(String(window.location.href))
    searchUrl.search = ""
    if (search.value) {
        searchUrl.searchParams.append("q", search.value)
    }

    if (fixedPrice.checked && !hourlyRate.checked) {
        searchUrl.searchParams.append("type", "fixed")
        if (minFPrice.value) {
            searchUrl.searchParams.append("min-fixed-price", minFPrice.value)
        }
        if (maxFPrice.value) {
            searchUrl.searchParams.append("max-fixed-price", maxFPrice.value)
        }
    } else if (!fixedPrice.checked && hourlyRate.checked) {
        searchUrl.searchParams.append("type", "hourly")
        if (minHPrice.value) {
            searchUrl.searchParams.append("min-hourly-price", minHPrice.value)
        }
        if (maxHPrice.value) {
            searchUrl.searchParams.append("max-hourly-price", maxHPrice.value)
        }
    } else {
        if (minFPrice.value) {
            searchUrl.searchParams.append("min-fixed-price", minFPrice.value)
        }
        if (maxFPrice.value) {
            searchUrl.searchParams.append("max-fixed-price", maxFPrice.value)
        }
        if (minHPrice.value) {
            searchUrl.searchParams.append("min-hourly-price", minHPrice.value)
        }
        if (maxHPrice.value) {
            searchUrl.searchParams.append("max-hourly-price", maxHPrice.value)
        }
    }

    if (brLang.checked && !enLang.checked) {
        searchUrl.searchParams.append("country", "br")
    } else if (!brLang.checked && enLang.checked) {
        searchUrl.searchParams.append("country", "us")
    }

    //alert(searchUrl)
    window.location.href = searchUrl.href
}

window.addEventListener("load", e => {
    if (window.innerWidth <= 1000) {
        document.querySelector(".filter-area").remove()
        filterReset()
    }
    
    let searchUrl = new URL(String(window.location.href))
    if (searchUrl.searchParams.has("q")) {
        search.value = url.searchParams.get("q")
    }

    if (searchUrl.searchParams.get("type") == "fixed") {
        fixedPrice.click()
    } else if (url.searchParams.get("type") == "hourly") {
        hourlyRate.click()
    } else {
        fixedPrice.click()
        hourlyRate.click()
    }

    if (searchUrl.searchParams.has("country")) {
       if (url.searchParams.get("country") == "br") {
            brLang.click()
        } else if (url.searchParams.get("country") == "us") {
            enLang.click()
        } else {
            brLang.click()
            enLang.click()
        } 
    } else {
        brLang.click()
        enLang.click()
    }

    if (searchUrl.searchParams.has("min-fixed-price")) {
        minFPrice.value = searchUrl.searchParams.get("min-fixed-price")
    }

    if (searchUrl.searchParams.has("max-fixed-price")) {
        maxFPrice.value = searchUrl.searchParams.get("max-fixed-price")
    }

    if (searchUrl.searchParams.has("min-hourly-price")) {
        minHPrice.value = searchUrl.searchParams.get("min-hourly-price")
    }

    if (searchUrl.searchParams.has("max-hourly-price")) {
        maxHPrice.value = searchUrl.searchParams.get("max-hourly-price")
    }

    if (searchUrl.searchParams.has("page")) {
        let page = searchUrl.searchParams.get("page")
        for (let c=0;c<numbers.length;c++) {
            if (numbers[c].innerHTML == Number(page)) {
                numbers[c].classList.add("number-selected")
            }
        }
    }

})

window.addEventListener("keypress", (event) => {
    if (event.keyCode == 13) {
        event.preventDefault()
        searchFilter.click()
    }
})

window.addEventListener("resize", e => {
    if (window.innerWidth >= 1000) {
        window.location.reload()
    } else {
        document.querySelector(".filter-area").remove()
        filterReset()
    }
})

for (let c=0;c<numbers.length;c++) {
    numbers[c].addEventListener("click", e => {
        let tempUrl = new URL(String(window.location.href))
        tempUrl.searchParams.delete("page")
        tempUrl.searchParams.append("page", Number(numbers[c].innerHTML))
        window.location.href = tempUrl.href
    });
}

nextPage.addEventListener("click", e=> {
    if (url.searchParams.has("page")) {
        let page = url.searchParams.get("page")
        url.searchParams.delete("page")
        url.searchParams.append("page", Number(page) + 1)
    } else {
        url.searchParams.append("page", "1")
    }
    window.location.href = url.href
})

backPage.addEventListener("click", e => {
    if (url.searchParams.has("page")) {
        let page = url.searchParams.get("page")
        url.searchParams.delete("page")
        url.searchParams.append("page", Number(page) - 1)
    } else {
        url.searchParams.append("page", "1")
    }
    window.location.href = url.href
})

document.getElementById("search-submit").addEventListener("click", e => {
    searchFilter.click()
})

document.getElementById("search-filter").addEventListener("click", e => {
    searchActive()
})

clearTypeProject.addEventListener("click", e => {
    fixedPrice.checked = false
    hourlyRate.checked = false
})

clearFixedPrice.addEventListener("click", e => {
    minFPrice.value = ""
    maxFPrice.value = ""
})

clearHourlyPrice.addEventListener("click", e => {
    minHPrice.value = ""
    maxHPrice.value = ""
})

clearLinguagem.addEventListener("click", e => {
    brLang.checked = false
    enLang.checked = false
})

document.getElementById("filtro-button").addEventListener("click", clickFilterArea)
document.getElementById("filtro-button-phone").addEventListener("click", clickFilterArea)
document.getElementById("close-filter-area").addEventListener("click", clickFilterArea)
