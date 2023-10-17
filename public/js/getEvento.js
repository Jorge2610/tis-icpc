//Recuperar eventos para mostrar en el front
document.addEventListener("DOMContentLoaded", function () {
    // Tu código para recuperar la lista de eventos aquí
    console.log("tesT");
    axios.get('/api/evento')
        .then(function (response) {
            var eventos = response.data;
            var listaEventos = document.getElementById('lista-eventos');
  
            eventos.forEach(function (evento) {
                var listItem = document.createElement('li');
                listItem.textContent = evento.nombre; // Ajusta esto según la estructura de tus datos
                listaEventos.appendChild(listItem);
            });
        })
        .catch(function (error) {
            console.error(error);
        });
  });