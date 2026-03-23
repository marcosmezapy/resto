<?php

function sucursal_id()
{
    return session('sucursal_id');
}

function tenant_id()
{
    return auth()->user()?->tenant_id;
}

function sucursal()
{
    return \App\Models\Sucursal::find(session('sucursal_id'));
}