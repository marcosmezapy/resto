<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesIAController extends Controller
{

public function index()
{
    return view('reportes_ia.index');
}

public function consultar(Request $request)
{

$mensaje = $request->mensaje;

try{

$client = \OpenAI::client(env('OPENAI_API_KEY'));

$response = $client->chat()->create([
'model'=>'gpt-4o-mini',
'messages'=>[
[
'role'=>'system',
'content'=>"

Eres un experto en SQL para MariaDB especializado en sistemas POS.

Debes devolver JSON con esta estructura:

{
\"consultas\":[
{
\"titulo\":\"titulo del reporte\",
\"sql\":\"consulta SQL\",
\"grafico\":\"bar|line|pie\"
}
]
}

Reglas:

Genera SOLO SELECT.
Nunca generes INSERT, UPDATE o DELETE.

MariaDB usa ONLY_FULL_GROUP_BY.
Cuando uses GROUP BY debes incluir todas las columnas seleccionadas.

Tipos de gráfico:

bar → ranking
line → evolución temporal
pie → distribución

---------------------------------------
BASE DE DATOS
---------------------------------------

ventas v
id
total
mesa_id
cliente_id
usuario_id
created_at

venta_detalles vd
venta_id
producto_id
cantidad
precio
subtotal
costo_unitario

prd_productos p
id
nombre
costo_base
precio_venta
es_stockeable

venta_pagos vp
venta_id
metodo_pago
monto

mesas m
id
numero

clientes c
id
nombre

---------------------------------------
RELACIONES
---------------------------------------

vd.venta_id = v.id
vd.producto_id = p.id

---------------------------------------
JOIN CORRECTO
---------------------------------------

FROM ventas v
JOIN venta_detalles vd ON v.id = vd.venta_id
JOIN prd_productos p ON vd.producto_id = p.id

---------------------------------------
UTILIDAD
---------------------------------------

vd.subtotal - (vd.cantidad * vd.costo_unitario)

---------------------------------------
MES ACTUAL
---------------------------------------

MONTH(v.created_at)=MONTH(CURDATE())
AND YEAR(v.created_at)=YEAR(CURDATE())

"
],
[
'role'=>'user',
'content'=>$mensaje
]
]
]);

$respuesta = $response->choices[0]->message->content;

/* limpiar markdown */

$respuesta = str_replace("```json","",$respuesta);
$respuesta = str_replace("```","",$respuesta);
$respuesta = trim($respuesta);

$data = json_decode($respuesta,true);

if(!$data){

return response()->json([
"error"=>"La IA devolvió una respuesta inválida",
"raw"=>$respuesta
]);

}

$resultados = [];

foreach($data['consultas'] as $consulta){

$sql = $consulta['sql'];
$grafico = $consulta['grafico'] ?? "bar";
$titulo = $consulta['titulo'] ?? "Reporte";

/* seguridad */

if(!str_starts_with(strtolower($sql),'select')){
continue;
}

/* evitar multiples queries */

if(str_contains($sql,';')){
$sql = explode(';',$sql)[0];
}

$res = DB::select($sql);

$resultados[]=[
"titulo"=>$titulo,
"sql"=>$sql,
"grafico"=>$grafico,
"data"=>$res
];

}

return response()->json([
"pregunta"=>$mensaje,
"consultas"=>$resultados
]);

}catch(\Exception $e){

return response()->json([
"error"=>$e->getMessage()
]);

}

}

}