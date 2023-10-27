
window.addEventListener("load", () => {
    let url = window.location.href;
    let opciones = document.getElementById("menuLateral").getElementsByTagName("a");
    for (let opcion of opciones) {
        if(opcion.href === url){
            opcion.classList.add("active");
            return;
        }
    }
});
