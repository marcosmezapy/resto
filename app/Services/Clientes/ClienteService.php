<?php

namespace App\Services\Clientes;

use App\Models\Cliente;

class ClienteService
{
    public function store(array $data)
    {
        return Cliente::create($data);
    }

    public function update($cliente, array $data)
    {
        $cliente->update($data);
        return $cliente;
    }

    public function delete($cliente)
    {
        return $cliente->delete();
    }
}