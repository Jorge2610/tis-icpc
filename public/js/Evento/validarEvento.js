form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
    Element.addEventListener("change", () => {
        if (Element.hasAttribute("required"))
            isValid(Element, Element.value != "");
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

const validarEdad = () => {
    if (boolMaxEdad && boolMinEdad && boolcheckEdad) {
        boolMaxEdad = false;
        boolMinEdad = false;
        edadMaxima.dispatchEvent(new Event("change"));
        edadMinima.dispatchEvent(new Event("change"));
    } else {
        boolcheckEdad = true;
    }

    if (
        edadMaxima.classList.contains("is-invalid") ||
        edadMinima.classList.contains("is-invalid")
    ) {
        isValid(inputEdad, false)
    } else {
        isValid(inputEdad, true);
    }
    if (!inputEdad.checked) {
        inputEdad.classList.remove("is-valid");
        inputEdad.classList.remove("is-invalid");
    }
};

const validarCosto = () => {
    if (boolCosto) {
        boolCosto = false;
        costo.dispatchEvent(new Event("change"));
    } else {
        boolCosto = true;
    }
    if (costo.classList.contains("is-invalid")) {
        isValid(inputCosto, false)
    } else {
        isValid(inputCosto, true)
    }
    if (!inputCosto.checked) {
        inputCosto.classList.remove("is-valid");
        inputCosto.classList.remove("is-invalid");
    }
};

costo.addEventListener("keyup", () => {
    let numero = costo.value.toString();
    var decimales = (numero.split('.')[1] || []).length;
    if (decimales > 1) {
        numero = numero.split('.')[0] + "." + numero.split('.')[1][0];
        costo.value = numero;
    }
});

costo.addEventListener("change", () => {


    if (inputCosto.checked){
        if (parseFloat(costo.value)>=
            parseFloat(costo.min) && parseFloat(costo.value)<= parseFloat(costo.max)) {
            isValid(costo, true);
        }else{
            isValid(costo, false);
        }
    } 
    else {
        isValid(costo, true);
    }
    if (boolCosto) {
        boolCosto = false;
        validarCosto();

    } else {
        boolCosto = true;
    }
});

fechaInicio.addEventListener("change", () => {
    if(fechaInicio.classList.contains("is-invalid")){
        document.getElementById("mensajeErrorFechaInicio").innerHTML="Seleccione una fecha y hora.";
    }
    if ((fechaInicio.value < fechaInicio.min &&
        fechaInicio.value !== "")
    ) {
        isValid(fechaInicio, false);
        document.getElementById("mensajeErrorFechaInicio").innerHTML="Seleccione una fecha correcta.";
    } else {
        if (!fechaInicio.hasAttribute('disabled')){
            boolFecha=false;
            fechaFin.min = fechaInicio.value;
        }
        else{
            boolFecha=true;
        }
    }
    if(fechaInicio.classList.contains("is-valid")){
        fechaFin.disabled=false;
        fechaFin.dispatchEvent(new Event("change"));
    }     
    else{
        fechaFin.disabled=true;
        fechaFin.value="";
        fechaFin.classList.remove("is-valid");
        fechaFin.classList.remove("is-invalid");
    }
        
}); 

fechaFin.addEventListener("change", () => {
    if(fechaFin.classList.contains("is-invalid")){
        document.getElementById("mensajeErrorFechaFin").innerHTML="Seleccione una fecha y hora.";
    }
    if (fechaFin.value < fechaFin.min && fechaFin.value !== "") {
        isValid(fechaFin);
        document.getElementById("mensajeErrorFechaFin").innerHTML="Seleccione una fecha correcta.";
        fechaInicio.max="";
    }
    if(boolFecha){
        boolFecha=false;
    }
    else{
        boolFecha=true;
    }
});

edadMaxima.addEventListener("change", () => {
    let ambos = edadMaxima.value === "" && edadMinima.value === "";
    if (parseInt(edadMaxima.value) < parseInt(edadMaxima.min) && (edadMaxima.value !== "")) {
        isValid(edadMaxima, false);
    } else {
        if (ambos && inputEdad.checked) {
            isValid(edadMaxima, false);
        } else {
            if (edadMaxima.value > parseInt(edadMaxima.max)) {
                isValid(edadMaxima, false);
            }
            else {
                isValid(edadMaxima, true);
                if (edadMaxima.value !== "" && edadMinima.value === "") {
                    document.getElementById("ValidoRangoEdad").innerText = "Edad válida hasta los " + edadMaxima.value + " años.";
                }
                else {
                    if (edadMinima.value !== "" && edadMaxima.value !== "")
                        document.getElementById("ValidoRangoEdad").innerText = "";
                }
            }

        }
    }
    if (boolMinEdad && boolMaxEdad && boolcheckEdad) {
        boolMinEdad = false;
        boolcheckEdad = false;
        edadMinima.dispatchEvent(new Event("change"));
        validarEdad();
    } else {
        boolMaxEdad = true;
    }
});
edadMinima.addEventListener("change", () => {
    let ambos = edadMaxima.value === "" && edadMinima.value === "";

    if (parseInt(edadMinima.value) < parseInt(edadMinima.min) && edadMinima.value !== "") {
        isValid(edadMinima, false);
    } else {
        if (ambos && inputEdad.checked) {
            isValid(edadMinima, false);
        } else {
            if (edadMinima.value > parseInt(edadMinima.max))
                isValid(edadMinima, false);
            else {
                if (edadMinima.value !== "")
                    edadMaxima.min = edadMinima.value;
                isValid(edadMinima, true);
                if (edadMinima.value !== "" && edadMaxima.value === "") {
                    document.getElementById("ValidoRangoEdad").innerText = "Edad válida desde los " + edadMinima.value + " años.";
                }
                else {
                    if (edadMaxima.value !== "" && edadMinima.value !== "")
                        document.getElementById("ValidoRangoEdad").innerText = "";
                }
            }
        }


    }

    if (boolMinEdad && boolMaxEdad && boolcheckEdad) {
        boolMaxEdad = false;
        boolcheckEdad = false;
        edadMaxima.dispatchEvent(new Event("change"));
        validarEdad();
    } else {
        boolMinEdad = true;
    }

});
inputCosto.addEventListener("change", () => {
    validarCosto();
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

inputEdad.addEventListener("change", () => {
    validarEdad();
});

checkTodasRango.addEventListener("change", () => {
    document.querySelectorAll(".grado-requerido").forEach((Element) => {
        if (!Element.disabled) {
            Element.checked = checkTodasRango.checked;
        }
    });
});

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
        checkEquipo.classList.remove("is-valid");
        checkEquipo.classList.remove("is-invalid");
        equipoMinimo.classList.remove("is-invalid");
        equipoMaximo.classList.remove("is-invalid");
    }
    
});
equipoMinimo.addEventListener("change",()=>{
    if(equipoMinimo.value!==""
        &&((parseInt(equipoMinimo.value)>parseInt(equipoMinimo.max))
        ||(parseInt(equipoMinimo.value)<parseInt(equipoMinimo.min)))){
        document.getElementById("ValidarRangoEquipo").innerText="Rango de cantidad de equipos no valido";
        isValid(equipoMinimo,false);
    }
    else{
        isValid(equipoMinimo,true);
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
    if(equipoMaximo.value!==""
    &&((parseInt(equipoMaximo.value)<=parseInt(equipoMaximo.max))
    &&(parseInt(equipoMaximo.value)>=parseInt(equipoMaximo.min)))){
        isValid(equipoMaximo,true);
        equipoMinimo.max=equipoMaximo.value;
    }else{if(equipoMaximo.value!==""){
            document.getElementById("ValidarRangoEquipo").innerText="La cantidad máxima de equipos no puede ser vacío.";
        }else{
            document.getElementById("ValidarRangoEquipo").innerText="Rango de cantidad de equipos no válido.";
        }
        isValid(equipoMaximo,false);
    }
    if(boolMinEquipo && boolMaxEquipo && boolCheckEquipo){
        boolMinEquipo = false;
        boolCheckEquipo = false;
        equipoMinimo.dispatchEvent(new Event("change"));
        checkEquipo.dispatchEvent(new Event("change"));
    } else {
        boolMaxEquipo = true;
    }
})

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