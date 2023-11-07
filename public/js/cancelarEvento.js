let tablaDeTipos;
let tablaInicializada = false;
let idEvento = null;
let contraseña = "admin123";

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, 'desc']],
    language: {
        lengthMenu: "Mostrar _MENU_ eventos",
        zeroRecords: "Ningún tipo de evento encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ eventos",
        infoEmpty: "Ningún evento encontrado",
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

window.addEventListener("load", () => {
    initDataTable();
    document.getElementById("contrasenia").pattern = contraseña;
});

const initDataTable = async () => {
    if (tablaInicializada) {
        tablaDeTipos.destroy();
    }
    DataTable.datetime('DD-MM-YYYY');
    tablaDeTipos = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

const setEventoId = (id) => {
    idEvento = id;
};

const cancelarEvento = async () => {
    let formData = crearFormDataCancelar();
    guardarForm(
        `/api/evento/cancelar/${idEvento}`,
        formData,
        "Error al cancelar el evento"
    );
    resetModalCancelar();
    recargarEventos();
}

const crearFormDataCancelar = () => {
    const formData = new FormData();
    formData.append(
        "motivo",
        document.getElementById("motivoCancelacion").value
    );
    return formData;
};

const anularEvento = async () => {
    let formData = crearFormDataAnular();
    if (validarAnulacion()) {
        guardarForm(
            `/api/evento/anular/${idEvento}`,
            formData,
            "Error al anular el evento"
        );
        resetModalAnular();
        recargarEventos();
    }
};

const crearFormDataAnular = () => {
    const formData = new FormData();
    formData.append("motivo", document.getElementById("motivoAnulacion").value);
    formData.append("descripcion", document.getElementById("descripcionAnulacion").value);
    formData.append("archivos", document.getElementById("archivosRespaldo").files[0]);
    return formData;
};

const validarAnulacion = () => {
    let form = document.getElementById("formularioAnulacion");
    if (form.checkValidity()) {
        form.classList.remove("was-validated");
        return true;
    }
    form.classList.add("was-validated");
    return false;
};

const guardarForm = async (ruta, formData, msgError) => {
    await axios
        .post(ruta, formData)
        .then((response) => {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.error ? "danger" : "success"
            );
        })
        .catch((error) => {
            mostrarAlerta("Fracaso", msgError, "danger");
        });
};

const resetModalCancelar = () => {
    $("#modalCancelar").modal("hide");
    document.getElementById("motivoCancelacion").value = "";
};

const resetModalAnular = () => {
    $("#modalAnular").modal("hide");
    document.getElementById("motivoAnulacion").value = "";
    document.getElementById("descripcionAnulacion").value = "";
    document.getElementById("archivosRespaldo").value = "";
    document.getElementById("contrasenia").value = "";
}

const recargarEventos = () => {
    setTimeout(() => {
        window.location.href = "/admin/eventos/cancelar-evento";
    }, 1800);
}
