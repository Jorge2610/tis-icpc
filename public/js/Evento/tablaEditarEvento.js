let tablaDeTipos;
let tablaInicializada = false;
let idEvento = null;
let contraseña = "admin123";

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, 'asc']],
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
});

const initDataTable = async () => {
    if (tablaInicializada) {
        tablaDeTipos.destroy();
    }
    DataTable.datetime('DD-MM-YYYY');
    tablaDeTipos = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

const redireccionarEditar=(url)=>{
    window.location.href = url;
}
