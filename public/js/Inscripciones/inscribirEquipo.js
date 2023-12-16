const contenido1 = $("#collapGmail");
const contenido2 = $("#collapseVerificaiconGmail");
const modal= document.getElementById("modal-inscribir");
const nombreInput =document.getElementById("nombreEquipo");
const correoInput = document.getElementById('inputEmail');
const validarGmail1= document.getElementById("codigoValidacion");
const contenedorCorreo = document.getElementById('contenedorCorreo');

let crear=true;
//funciones button
const ingresarNombreEquipo = () => {
    nombreInput.dispatchEvent(new Event("change"));
    if(nombreInput.classList.contains("is-valid")){
        contenido1.collapse("show");
    }
    else{
        console.log("esto no es valido");
    }
}
const mostrarValidacion = ()=>{
    correoInput.dispatchEvent(new Event("change"));
    if(correoInput.classList.contains("is-valid")){
        validarGmail1.style.display='block';
        contenedorCorreo.style.display="none";
    }
}
const registrarEquipo = ()=>{
    let formData=crearForData();
    if(crear){
        axios.post('/api/equipo/', formData)
        .then(function (response) {
            console.log('Respuesta del servidor:', response.data);
        })
        .catch(function (error) {
            console.error('Error en la petición:', error);
        });
    }
}
//funciones
const crearForData= ()=>{
    let formData={
        
    }
}
//validacion de inputs
const inputRequired=(input)=>{
    if(input.value==""){
        esValido(input,false);
    } else{
        esValido(input,true);
    }
}
const esValido = (componente, bandera) => {
    if (bandera) {
        componente.classList.remove("is-invalid");
        componente.classList.add("is-valid");
    }
    else {
        componente.classList.remove("is-valid");
        componente.classList.add("is-invalid");
    }
} 
const inputEmail = (input)=>{
    if(input.validity.valid){
        esValido(input,true);
    }else{
        esValido(input,false);
    }

}

//eventos
modal.addEventListener('hidden.bs.modal', function (event) {
    console.log("hola comoestas ");
    nombreInput.classList.remove("is-valid");
    nombreInput.classList.remove("is-invalid");
    contenido1.collapse("hide"); 
})
nombreInput.addEventListener("change",()=>{
    inputRequired(nombreInput);
})
correoInput.addEventListener("change",()=>{
    inputRequired(correoInput);
    inputEmail(correoInput)
})