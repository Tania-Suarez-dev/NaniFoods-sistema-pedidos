console.log("hola perros.")
const contador = document.getElementById("contador")
const el = document.getElementById("sumar")
const ei = document.getElementById("restar")
console.log(el)
// el.classList.add("principal")
// el.classList.remove("nav-items")
// el.style.color = "red"

el.addEventListener("click", function (event) {
    event.preventDefault()
    contador.innerText = parseInt(contador.innerText) + 1
    //document.getElementsByClassName("login")[0].style.display = "none"
    console.log(event)
})
ei.addEventListener("click", function (event) {
    event.preventDefault()
    contador.innerText = parseInt(contador.innerText) - 1
    //document.getElementsByClassName("login")[0].style.display = "none"
    console.log(event)
})