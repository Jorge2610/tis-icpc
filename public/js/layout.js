window.addEventListener("load", () => {
    let url = window.location.href;
    let items = document
        .getElementById("menuLateral")
        .getElementsByClassName("accordion-item");
    for (let item of items) {
        let opciones = item.getElementsByTagName("a");
        let boton = item.getElementsByTagName("button");
        let desplegable = item.getElementsByClassName("accordion-collapse");
        for (let opcion of opciones) {
            if (opcion.href === url) {
                boton[0].classList.remove("collapsed");
                desplegable[0].classList.add("show");
                opcion.classList.add("active");
                return;
            }
        }
    }
});
