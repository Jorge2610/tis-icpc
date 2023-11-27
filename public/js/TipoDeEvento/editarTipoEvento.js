let tablaDeTipos;
let tablaInicializada = false;
let form = document.getElementById("formularioTipoEvento");
const idTipoEvento = document.getElementById("id");
const botonCancelar = document.getElementById("cancelarBoton");
const inputNombre = document.getElementById("nombreTipoEvento");
const mensajeNombre = document.getElementById("mensajeNombre");
const inputDescripcion = document.getElementById("detalleTipoEvento");
let nombreAnterior = "";
const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, "desc"]],
    language: {
        lengthMenu: "Mostrar _MENU_ entradas",
        zeroRecords: "Ningún tipo de evento encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún usuario encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior",
        },
    },
};

const editarTipoEvento = (formData) => {
    //Si el tipo de evento existe entonces se guarda este valor y servirá para la validación
    nombreAnterior = inputNombre.value
    console.log("Este es el formulario que obtenemos del front " + formData);
    axios.post(`/api/tipo-evento/actualizar/${idTipoEvento.value}`, formData)
    .then(function(response){
        const mensaje = response.data.mensaje
        const nombreIgual = 'El tipo de evento ya existe'
        mostrarAlerta(
            "Éxito",
            mensaje,
            response.data.error ? "danger" : "success"
        );
        /**Si existe un tipo de evento con el mismo nombre, se mantiene los datos del formulario**/
        if(mensaje === nombreIgual){
            inputNombre.classList.remove("is-valid")
            inputNombre.classList.add("is-invalid")    
            inputDescripcion.classList.add("is-valid")
            mensajeNombre.textContent = 'El tipo de evento ya existe'
            console.log("Este es el inputNombre "+inputNombre);
        }else{
            //form.reset();
        }   
    }).catch(function(error){
        console.log(mensaje);
        mostrarAlerta("Error", "Hubo un error al guardar el tipo de evento", "danger");
    })
};

form.addEventListener("submit",(event) =>{
    event.preventDefault()
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.dispatchEvent(new Event("change"));
    });
    if(validar()){
        form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
            if(Element.disabled)
                Element.disabled=false;            
        });
        const formData = new FormData(form);
        editarTipoEvento(formData);
        
    }
})

const validar = () => {
    return form.querySelector(".is-invalid") === null;
};

//Agregar validación a los inputs
form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
    Element.addEventListener("change", () => {
        if (Element.hasAttribute("required") && Element.value === "") {
            Element.classList.remove("is-valid");
            Element.classList.add("is-invalid");
        } else {
            Element.classList.remove("is-invalid");
            Element.classList.add("is-valid");
        }
    });
});

function validarNombreRepetido() {
    const nuevoNombre = inputNombre.value.trim();

    if (nuevoNombre === '') {
        inputNombre.classList.remove('is-valid');
        inputNombre.classList.add('is-invalid');
        mensajeNombre.textContent = 'El nombre no puede estar vacío.';
    } else if (nuevoNombre === nombreAnterior) {
        inputNombre.classList.remove('is-invalid');
        inputNombre.classList.add('is-valid');
        mensajeNombre.textContent = '';
    } else {
        // Realizar la lógica para verificar si el nombre ya existe
        // Puedes realizar una solicitud al servidor aquí si es necesario
        // y actualizar las clases y mensajes en consecuencia.
    }
}

inputNombre.addEventListener('input', validarNombreRepetido);
// Puedes quitar uno de los dos eventos (input o change) si no son necesarios ambos.
// inputNombre.addEventListener('change', validarNombreRepetido);

inputNombre.addEventListener("input",validarNombreRepetido );
inputNombre.addEventListener("change",validarNombreRepetido );

function quitarValidacion(){
    form.querySelectorAll(".form-control, .form-select").forEach(
        (Element) => {
            Element.classList.remove("is-valid");
            Element.classList.remove("is-invalid");
        }
    );
}