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
    let numero = costo.value.toString();
    var decimales = (numero.split('.')[1] || []).length;
    if (decimales > 1) {
        numero = numero.split('.')[0] + "." + numero.split('.')[1][0];
        costo.value = numero;
    }
    if ((costo.value < costo.min || costo.value > costo.max || costo.value == "") && inputCosto.checked) {
        isValid(costo, false)
    }
    else {
        validarCosto();
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
    if (
        fechaInicio.value < fechaInicio.min &&
        fechaInicio.value !== "" &&
        fechaInicio.value != ""
    ) {
        isValid(fechaInicio, false);
    } else {
        if (!fechaInicio.hasAttribute('disabled'))
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
                    document.getElementById("ValidoRangoEdad").innerText = "Edad válida hasta los " + edadMaxima.value + " años";
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
                    document.getElementById("ValidoRangoEdad").innerText = "Edad válida desde los " + edadMinima.value + " años";
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
    let inputCosto = document.getElementById("costoEvento");
    let invalidFeedback = document.getElementById("costoInvalido");
    let value = inputCosto.value;
    value = parseFloat(value);
    if (value != NaN) {
        invalidFeedback.innerText =
            value < inputCosto.min ? "Monto mínimo " + inputCosto.min + " Bs." :
                value > inputCosto.max ? "Monto máximo " + inputCosto.max + " Bs.": "";
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