// window.addEventListener("load", () => {
//     cargarPatrocinadores();
// });

// const cargarPatrocinadores = async () => {
//     try {
//         const response = await getPatrocinadores();
//         const patrocinadores = response.data;
//         const contenedor = document.getElementById("contenedorPatrocinadores");

//         const content = patrocinadores
//             .map((patrocinador) => {
//                 const ruta = patrocinador.enlace_web
//                     ? patrocinador.enlace_web
//                     : "#";
//                 return `

//         `;
//             })
//             .join("");

//         contenedor.innerHTML = content;
//     } catch (error) {
//         alert(error);
//     }
// };

// const getPatrocinadores = async () => {
//     const id_evento = document.getElementById("id_evento").value;
//     const datos = await axios
//         .get(`/api/patrocinador/${id_evento}`)
//         .then((response) => {
//             return response;
//         })
//         .catch((error) => {
//             return error;
//         });
//     return datos;
// };
