const contenido1 = $("#collapGmail");
const contenido2 = $("#collapseVerificaiconGmail");
const modal= document.getElementById("modal-inscribir");
const nombreInput =document.getElementById("nombreEquipo");
const correoInput = document.getElementById('inputEmail');
const validarGmail1= document.getElementById("codigoValidacion");
const contenedorCorreo = document.getElementById('contenedorCorreo');
const buttonConfirmacion = document.getElementById('button-equipo-confirmacion');
const buttonCancelacion = document.getElementById('button-equipo-cancelar'); 
const codigoInput1 = document.getElementById('codigo1');

let crear=true;
//funciones button
const ingresarNombreEquipo = () => {
    nombreInput.dispatchEvent(new Event("change"));
    if(nombreInput.classList.contains("is-valid")){
        if(nombreInput.disabled){
            if(validarGmail1.style.display=='none')
                registrarCorreo();
            else
                verificarCodigo();
        }else{
            contenido1.collapse("show");
            nombreInput.disabled=true ; 
        }
        
    } 

}
const cancelarEquipo = ()=>{
    if(!nombreInput.disabled){
        $('#modal-inscribir').modal("hide");
    }else{
        if(validarGmail1.style.display=='none'){
            atrasCorreo();
        }else{
            atrasCodigo();
        }
    }
}
const registrarCorreo = ()=>{
    correoInput.dispatchEvent(new Event("change"));
    if(correoInput.classList.contains("is-valid")){
        validarGmail1.style.display='block';
        contenedorCorreo.style.display="none";
    }
}
const verificarCodigo=()=>{
    codigoInput1.dispatchEvent(new Event("change"));
    if(codigoInput1.classList.contains("is-valid")){
        console.log("registra tio porfavor");
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
const atrasCorreo = ()=>{
    contenido1.collapse("hide");
    removerValidacion(correoInput);
    nombreInput.disabled=false;
}
const atrasCodigo =()=>{
    removerValidacion(codigoInput1);
    validarGmail1.style.display='none';
    contenedorCorreo.style.display="block";
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
const removerValidacion= (input)=>{
    input.value="";
    input.classList.remove("is-valid");
    input.classList.remove("is-invalid");
}
//eventos
modal.addEventListener('hidden.bs.modal', function (event) {
    removerValidacion(nombreInput);
    nombreInput.disabled=false;
    removerValidacion(correoInput);
    contenido1.collapse("hide"); 
})
nombreInput.addEventListener("change",()=>{
    inputRequired(nombreInput);
})
correoInput.addEventListener("change",()=>{
    inputRequired(correoInput);
    inputEmail(correoInput);
})
codigoInput1.addEventListener("change",()=>{
    inputRequired(codigoInput1);
})