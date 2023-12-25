form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
    Element.addEventListener("change", () => {
        isValid(Element,Element.checkValidity());
        //validacion(Element);
    });
});

chekcTodas.addEventListener("change", () => {
    document.querySelectorAll(".institucion").forEach((Element) => {
        if (!Element.disabled) {
            Element.checked = chekcTodas.checked;
        }
    });
});
document.querySelectorAll(".institucion").forEach((Element) => {
    Element.addEventListener("change", () => {
        let bandera = true;
        document.querySelectorAll(".institucion").forEach((Element) => {
            if (!Element.disabled) {
                if (!Element.checked) {
                    bandera = false;
                }
            }

        });
        chekcTodas.checked = bandera;
    });
});
//Validacion de edad
edadMaxima.addEventListener("change", () => {
    if(!inputEdad.checked)
        isValid(edadMaxima,true);
    else{
        if(edadMaxima.classList.contains("is-invalid")){
            if(edadMaxima.value===""&&
            edadMinima.classList.contains("is-valid"))
                isValid(edadMaxima,true);
        }else{
            edadMinima.max=edadMaxima.value;
            if(edadMinima.value==="")
                document.getElementById("ValidoRangoEdad").innerText = "Edad válida hasta los " + edadMaxima.value + " años.";   
            else
                document.getElementById("ValidoRangoEdad").innerText = "";  
        }
    }
    if (boolMinEdad && boolMaxEdad && boolcheckEdad) {
        boolMinEdad = false;
        boolcheckEdad = false;
        edadMinima.dispatchEvent(new Event("change"));
        inputEdad.dispatchEvent(new Event("change"));
    } else {
        boolMaxEdad = true;
    }
});
edadMinima.addEventListener("change", () => {
    if(!inputEdad.checked)
        isValid(edadMinima,true);
    else{
        if(edadMinima.classList.contains("is-invalid")){
            if(edadMinima.value===""&&
            edadMaxima.classList.contains("is-valid"))
                isValid(edadMinima,true);
        }else{
            edadMaxima.min=edadMinima.value;
            if(edadMaxima.value==="")
                document.getElementById("ValidoRangoEdad").innerText = "Edad válida desde los " + edadMinima.value + " años.";   
            else
                document.getElementById("ValidoRangoEdad").innerText = "";  
        }
    }
    if (boolMinEdad && boolMaxEdad && boolcheckEdad) {
        boolMaxEdad = false;
        boolcheckEdad = false;
        edadMaxima.dispatchEvent(new Event("change"));
        inputEdad.dispatchEvent(new Event("change"));;
    } else {
        boolMinEdad = true;
    }

});
inputEdad.addEventListener("change", () => {
    if (boolMaxEdad && boolMinEdad && boolcheckEdad) {
        boolMaxEdad = false;
        boolMinEdad = false;
        edadMaxima.dispatchEvent(new Event("change"));
        edadMinima.dispatchEvent(new Event("change"));
    } else {
        boolcheckEdad = true;
    }
    isValid(inputEdad,edadMaxima.classList.contains("is-valid") &&
            edadMinima.classList.contains("is-valid"));    
    if (!inputEdad.checked) {
        removerValidacion(inputEdad);
    }
});
//Validacion de costo
costo.addEventListener("keyup", () => {
    let numero = costo.value.toString();
    var decimales = (numero.split('.')[1] || []).length;
    if (decimales > 1) {
        numero = numero.split('.')[0] + "." + numero.split('.')[1][0];
        costo.value = numero;
    }
});
costo.addEventListener("change", () => {
    if (!inputCosto.checked)
        isValid(costo, true);
    if (boolCosto){
        boolCosto=false
        inputCosto.dispatchEvent(new Event("change"));
    }else
        boolCosto = true;
});
inputCosto.addEventListener("change", () => {
    if (boolCosto){
        boolCosto=false
        costo.dispatchEvent(new Event("change"));
    }else
        boolCosto =true;
    if (!inputCosto.checked) {
        removerValidacion(inputCosto);
    }else
        isValid(inputCosto,costo.classList.contains("is-valid"));
});
//Validacion de fechas
fechaInicio.addEventListener("change", () => {
    if(fechaInicio.classList.contains("is-invalid")){
        fechaFin.disabled=true;
        fechaFin.value="";
        removerValidacion(fechaFin);
        if(fechaInicio==="")
            document.getElementById("mensajeErrorFechaInicio").innerHTML="Seleccione una fecha y hora.";
        else
            document.getElementById("mensajeErrorFechaInicio").innerHTML="Seleccione una fecha correcta.";
    }else{
        fechaFin.disabled=false;
        fechaFin.dispatchEvent(new Event("change"));
    }    
}); 
fechaFin.addEventListener("change", () => {
    if(fechaFin.classList.contains("is-invalid")){
        if(fechaFin.value=="")
            document.getElementById("mensajeErrorFechaFin").innerHTML="Seleccione una fecha y hora.";
        else
            document.getElementById("mensajeErrorFechaFin").innerHTML="Seleccione una fecha correcta.";
    }
});

const setCostoInvalidoFeedback = () => {
    let invalidFeedback = document.getElementById("costoInvalido");
    let value = costo.value;
    value = parseFloat(value);
    if (!isNaN(value)) {
        invalidFeedback.innerText =
            value < parseFloat(costo.min) ? "Monto mínimo " + costo.min + " Bs." :
                value > parseFloat(costo.max) ? "Monto máximo " + costo.max + " Bs.": "";
    }
    else{
        invalidFeedback.innerText="El costo no puede ser vacío."
    }
}
checkTodasRango.addEventListener("change", () => {
    document.querySelectorAll(".grado-requerido").forEach((Element) => {
        if (!Element.disabled) {
            Element.checked = checkTodasRango.checked;
        }
    });
});
document.querySelectorAll(".grado-requerido").forEach((Element) => {
    Element.addEventListener("change", () => {
        let bandera = true;
        document.querySelectorAll(".grado-requerido").forEach((Element) => {
            if (!Element.disabled) {
                if (!Element.checked) {
                    bandera = false;
                }
            }
        });
        checkTodasRango.checked = bandera;
    });
});
//validacion de equipo
checkEquipo.addEventListener("change",()=>{
    if (boolMaxEquipo && boolMinEquipo && boolCheckEquipo) {
        boolMaxEquipo = false;
        boolMinEquipo = false;

        equipoMaximo.dispatchEvent(new Event("change"));
        equipoMinimo.dispatchEvent(new Event("change"));
    } else {
        boolCheckEquipo = true;
    }
    if (
        equipoMaximo.classList.contains("is-invalid") ||
        equipoMinimo.classList.contains("is-invalid")
    ) {
        isValid(checkEquipo, false);
        isValid(equipoMaximo,false);
        isValid(equipoMinimo,false);
    } else {
        isValid(checkEquipo, true);
    }
    if (!checkEquipo.checked) {
        removerValidacion(checkEquipo);
        equipoMinimo.classList.remove("is-invalid");
        equipoMaximo.classList.remove("is-invalid");
    }
});
equipoMinimo.addEventListener("change",()=>{
    if(equipoMinimo.classList.contains("is-invalid")){
        document.getElementById("ValidarRangoEquipo").innerText="Rango de cantidad de equipos no valido";
    }else{
        if(equipoMinimo.value==="")
            equipoMaximo.min=2;
        else
            equipoMaximo.min=equipoMinimo.value;
    }
    if(boolMinEquipo && boolMaxEquipo && boolCheckEquipo){
        boolMaxEquipo = false;
        boolCheckEquipo = false;
        equipoMaximo.dispatchEvent(new Event("change"));
        checkEquipo.dispatchEvent(new Event("change"));
    } else {
        boolMinEquipo = true;
    }
})
equipoMaximo.addEventListener("change",()=>{
    if(equipoMaximo.classList.contains("is-invalid")){
        if(equipoMaximo.value=="")
            document.getElementById("ValidarRangoEquipo").innerText=`La cantidad m\u00E1xima de equipos no puede ser vacío.`;
        else
            document.getElementById("ValidarRangoEquipo").innerText="Rango de cantidad de equipos no v\xE1lido.";
    }else
        equipoMinimo.max=equipoMaximo.value;
    if(boolMinEquipo && boolMaxEquipo && boolCheckEquipo){
        boolMinEquipo = false;
        boolCheckEquipo = false;
        equipoMinimo.dispatchEvent(new Event("change"));
        checkEquipo.dispatchEvent(new Event("change"));
    } else {
        boolMaxEquipo = true;
    }
})

const isValid = (componente, bandera) => {
    if (bandera) {
        componente.classList.remove("is-invalid");
        componente.classList.add("is-valid");
    }
    else {
        componente.classList.remove("is-valid");
        componente.classList.add("is-invalid");
    }
}
const removerValidacion = (componente)=>{
    componente.classList.remove("is-invalid");
    componente.classList.remove("is-valid");
}
document.querySelectorAll(".entero").forEach((Element)=>{
    Element.addEventListener("keyup",()=>{
        console.log(Element.value.includes("."));
        if (Element.value.includes(".")) {
            let numero = Element.value.split('.')[0];
            console.log(numero);
            Element.value = numero;
        }
    });
})