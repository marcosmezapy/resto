@extends('adminlte::page')

@section('title','Reportes Inteligentes')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid">

<div class="card">

<div class="card-header">
<b>Asistente Inteligente de Reportes</b>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-10">

<input type="text"
id="mensaje"
class="form-control"
placeholder="Ej: ventas este mes y utilidad por producto">

</div>

<div class="col-md-2">

<button class="btn btn-primary btn-block" onclick="consultar()">
Consultar
</button>

</div>

</div>

</div>

</div>

<div id="errores" class="alert alert-danger mt-3" style="display:none"></div>

<div id="reportes"></div>

</div>


<script>

function consultar(){

let mensaje = document.getElementById("mensaje").value;

document.getElementById("errores").style.display="none";
document.getElementById("reportes").innerHTML="";

fetch("{{ route('reportes.ia.consultar') }}",{

method:"POST",

headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":"{{ csrf_token() }}"
},

body:JSON.stringify({
mensaje:mensaje
})

})

.then(res=>res.json())

.then(data=>{

if(data.error){

mostrarError(data.error);
return;

}

renderizar(data.consultas);

});

}

function mostrarError(msg){

let div = document.getElementById("errores");

div.style.display="block";
div.innerHTML="<b>Error:</b><br>"+msg;

}

function renderizar(consultas){

let contenedor = document.getElementById("reportes");

consultas.forEach((c,i)=>{

let card = document.createElement("div");

card.className="card mt-3";

card.innerHTML = `
<div class="card-header">
<b>${c.titulo}</b>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">
<canvas id="grafico_${i}"></canvas>
</div>

<div class="col-md-6">

<table class="table table-bordered">

<thead></thead>
<tbody></tbody>

</table>

</div>

</div>

</div>
`;

contenedor.appendChild(card);

/* tabla */

let columnas = Object.keys(c.data[0] || {});

let thead = card.querySelector("thead");
let tbody = card.querySelector("tbody");

let trh="<tr>";

columnas.forEach(col=>{
trh+="<th>"+col+"</th>";
});

trh+="</tr>";

thead.innerHTML=trh;

c.data.forEach(row=>{

let tr="<tr>";

columnas.forEach(col=>{
tr+="<td>"+row[col]+"</td>";
});

tr+="</tr>";

tbody.innerHTML+=tr;

});

/* grafico */

let labels=[];
let valores=[];

c.data.forEach(r=>{
labels.push(Object.values(r)[0]);
valores.push(Object.values(r)[1]);
});

new Chart(

document.getElementById("grafico_"+i),

{
type:c.grafico,

data:{
labels:labels,
datasets:[
{
label:c.titulo,
data:valores
}
]
}

}

);

});

}

</script>

@endsection