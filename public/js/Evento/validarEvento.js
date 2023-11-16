form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
    Element.addEventListener("change", () => {
        if(Element.hasAttribute("required"))
            isValid(Element, Element.value != "");
    });
});

chekcTodas.addEventListener("change", () => {
    document.querySelectorAll(".institucion").forEach((Element) => {
        if(!Element.disabled){
            Element.checked=chekcTodas.checked;
        }       
    });
});

document.querySelectorAll(".institucion").forEach((Element) => {
    Element.addEventListener("change", () => {
        let bandera = true;
        document.querySelectorAll(".institucion").forEach((Element) => {
            if(!Element.disabled){
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
        edadMaxima.classList.contains("is-invalid")
    ) {
        isValid(inputEdad,false)
    } else {
        isValid(inputEdad,true);
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
        isValid(inputCosto,false)
    } else {
        isValid(inputCosto,true)
    }
};


costo.addEventListener("change", () => {
    if ((costo.value < costo.min || costo.value == "") && inputCosto.checked) {
        isValid(costo,false)
    }
    if (boolCosto) {
        boolCosto = false;
        validarCosto();
    } else {
        boolCosto = true;
    }
});

fechaInicio.addEventListener("change", () => {
    if (
        fechaInicio.value < fechaInicio.min &&
        fechaInicio.value !== "" &&
        fechaInicio.value != ""
    ) {
        isValid(fechaInicio,false);
    } else {
        fechaFin.min = fechaInicio.value;
        fechaFin.dispatchEvent(new Event("change"));

    }
});

fechaFin.addEventListener("change", () => {
    if (fechaFin.value < fechaFin.min && fechaFin.value !== "") {
        isValid(fechaFin);
    }
});

edadMaxima.addEventListener("change", () => {
    let ambos = edadMaxima.value === "" && edadMinima.value === "";
    if (parseInt(edadMaxima.value) < parseInt(edadMaxima.min) && edadMaxima.value !== "") {
        isValid(edadMaxima,false);
    } else {
        if (ambos && inputEdad.checked) {
            isValid(edadMaxima,false);
        } else {
            isValid(edadMaxima,true);
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
        isValid(edadMinima,false);
    } else {
        if(edadMinima.value !== ""){}
            edadMaxima.min = edadMinima.value;
    }
    
    if (ambos && inputEdad.checked) {
        isValid(edadMinima,false);
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
inputEdad.addEventListener("change", () => {
    validarEdad();
});

checkTodasRango.addEventListener("change", () => {
    document.querySelectorAll(".grado-requerido").forEach((Element) => {
        if(!Element.disabled){
            Element.checked =checkTodasRango.checked;
        }
    });
});

document.querySelectorAll(".grado-requerido").forEach((Element) => {
    Element.addEventListener("change", () => {
        let bandera = true;
        document.querySelectorAll(".grado-requerido").forEach((Element) => {
            if(!Element.disabled){
                if (!Element.checked) {
                    bandera = false;
                }
            }
        });
        checkTodasRango.checked = bandera;
    });
});

const isValid=(componente,bandera)=>{
    if(bandera){
        componente.classList.remove("is-invalid");
        componente.classList.add("is-valid");
    }
    else{
        componente.classList.remove("is-valid");
        componente.classList.add("is-invalid");
    }
}