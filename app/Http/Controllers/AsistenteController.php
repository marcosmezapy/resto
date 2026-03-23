<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class AsistenteController extends Controller
{

    public function index()
    {
        return view('asistente.index');
    }

public function procesar(Request $request)
{

try{

$mensaje = $request->mensaje;

$client = \OpenAI::client(env('OPENAI_API_KEY'));

$response = $client->chat()->create([
'model' => 'gpt-4o-mini',
'messages' => [
[
'role' => 'system',
'content' => '
Eres un asistente de un POS de restaurante.

Debes responder SIEMPRE en JSON.

Ejemplo:

usuario: vender 2 hamburguesas y 1 coca

respuesta:

{
 "accion":"crear_venta",
 "items":[
  {"producto":"hamburguesa","cantidad":2},
  {"producto":"coca cola","cantidad":1}
 ]
}
'
],
[
'role' => 'user',
'content' => $mensaje
]
]
]);

$texto = $response->choices[0]->message->content;

$data = json_decode($texto,true);

return response()->json([
'interpretacion'=>$data
]);

}catch(\Exception $e){

return response()->json([
'error'=>$e->getMessage()
]);

}

}

}