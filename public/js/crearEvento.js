let fechaInscripcionInicio = document.getElementById('fechaInscripcionInicio')
let fechaInscripcionFin = document.getElementById('fechaInscripcionFin')

fechaInscripcionInicio.addEventListener('change',(e)=>{
  let valor = e.target.value
  fechaInscripcionFin.setAttribute('min', valor)
})

let fechaInicio = document.getElementById('fechaInicio')
let fechaFin = document.getElementById('fechaFin')

fechaInicio.addEventListener('change',(e)=>{
    let valor = e.target.value
    fechaFin.setAttribute('min', valor)
  })