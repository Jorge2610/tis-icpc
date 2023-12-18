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
const form = document.getElementById('inscribirEquipo');
const mensaCorreo = document.getElementById('mensajeErrorCorreo');

let crear=true;
let Datos;
let id_equipo;
//funciones button
const ingresarNombreEquipo = () => {
    nombreInput.dispatchEvent(new Event("change"));
    correoInput.dispatchEvent(new Event ("change"));
    if(nombreInput.classList.contains("is-valid")
        &&correoInput.classList.contains("is-valid")){
        if(validarGmail1.style.display=='none'){
            registrarCorreo();
        }
        else{
            codigoInput1.dispatchEvent(new Event("change"));
            if(codigoInput1.classList.contains("is-valid")){
                crearEquipo(); 
            }
        }
        
    } 

}
const crearEquipo=async()=>{
    let formData=new FormData();
    formData.append("codigo",codigoInput1.value);
    if(crear){
        const response = await axios.post("/api/equipo/verificarCodigo/"+id_equipo,formData)
          .catch(error => {
            // Manejar errores
            console.error('Error al obtener datos:', error);
          });
        if(response.data.error){
            esValido(codigoInput1,false);
            mensaCorreo.innerText="Código incorrecto.";
            participanteYaInscrito(response);

        }else{
            localStorage.setItem("codigo",codigoInput1.value);
            console.log(localStorage.getItem('codigo'));
            window.location.href= "/eventos/tabla-equipo/"+codigoInput1.value+"/"+nombreInput.getAttribute("evento_id");
        }
    }
}
const cancelarEquipo = ()=>{
    if(!nombreInput.disabled){
        $('#modal-inscribir').modal("hide");
    }else{
            correoInput.disabled=false;
            nombreInput.disabled=false;
            atrasCodigo();
    }
}
const registrarCorreo = async()=>{
        await registrarEquipo();
        validarGmail1.style.display='block';
        nombreInput.disabled=true;
        correoInput.disabled=true;
}
const verificarCodigo=()=>{
    codigoInput1.dispatchEvent(new Event("change"));
    if(codigoInput1.classList.contains("is-valid")){
        console.log("registra tio porfavor");
    }
}
const registrarEquipo = async()=>{
    var formData = new FormData();
    // Agregar datos al FormData
    formData.append('nombre', nombreInput.value);
    formData.append('correo_general', correoInput.value);
    formData.append('id_evento',nombreInput.getAttribute("evento_id"))
    formData.forEach(function(valor, clave) {
        console.log("Clave:", clave, "Valor:", valor);
    });
        const response = await axios.post('/api/equipo/existe', formData)
        .catch(function (error) {
            console.error('Error en la petición:', error);
        });

        if(response.data.inscrito){
            participanteYaInscrito(response);
            console.log("este equipo ya esta registrado y inscrito");
        }else{
            if(response.data.equipo){
                console.log(response.data)
                id_equipo=response.data.equipo.id;
                formData.append('id_equipo',response.data.equipo.id);
            }
                
            registrarEquipoEvento(formData);
        }
    
}
const enviarCorreo = (id_equipo,id_evento)=>{
    axios.post('/api/enviarCorreo/'+id_equipo+'/'+id_evento)
    .then(response => {
        // Manejar la respuesta exitosa
        console.log('Datos:', response.data);
      })
      .catch(error => {
        // Manejar errores
        console.error('Error al obtener datos:', error);
      });
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
const registrarEquipoEvento=(formData)=>{
    
    axios.post("/api/equipo/inscribirEquipo",formData)
    .then(function (response) {
        console.log('Respuesta del servidor:', response.data);
        if(response.data.equipo){
            id_equipo=response.data.equipo.id;
        }
    })
    .catch(function (error) {
        console.error('Error en la petición:', error);
    });
}
const reEnviarCodigo = async()=>{
    let res = await enviarCodigoAcceso();
    mostrarAlerta(
        "Éxito",
        res.mensaje,
        res.error ? "danger" : "success"
    );
}
const enviarCodigoAcceso = async () => {
    let data = await axios.post("/api/participante/enviarCodigo/" + idEvento + "/" + idParticipante).then(response => {
        return response.data;
    });
    return data;
};
const participanteYaInscrito = (response) => {
    //$('#modal-inscribir').modal('hide');
    //resetModal();
    mostrarAlerta(
        "Éxito",
        response.data.mensaje,
        response.data.error ? "danger" : "success"
    );
};
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
        mensaCorreo.innerText="Correo inválido.";
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
    correoInput.disabled=false;
    validarGmail1.style.display='none';
    removerValidacion(codigoInput1);
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