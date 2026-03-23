<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubmoduleController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Compras\CompraController;
use App\Http\Controllers\Productos\ClasificacionController;
use App\Http\Controllers\Productos\DepositoController;
use App\Http\Controllers\Productos\MovimientoStockController;
use App\Http\Controllers\Productos\ProductoController;
use App\Http\Controllers\Productos\StockController;
use App\Http\Controllers\Productos\StockProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReportesIAController;
use App\Http\Controllers\Restaurante\MesaController;
use App\Http\Controllers\Sucursales\SucursalController;
use App\Http\Controllers\SucursalSeleccionController;
use App\Http\Controllers\Ventas\CajaController;
use App\Http\Controllers\Ventas\CajaSesionController;
use App\Http\Controllers\Ventas\MovimientoCajaController;
use App\Http\Controllers\Ventas\PosController;
use App\Http\Controllers\Ventas\PagoController;
use App\Http\Controllers\Ventas\VentaController;



Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');

});



/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])
->prefix('administrador')
->name('administrador.')
->group(function(){

    Route::get('usuarios',[UserController::class,'index'])->name('usuarios.view');
    Route::get('usuarios/create',[UserController::class,'create'])->name('usuarios.create');
    Route::post('usuarios',[UserController::class,'store'])->name('usuarios.store');
    Route::get('usuarios/{user}/edit',[UserController::class,'edit'])->name('usuarios.edit');
    Route::put('usuarios/{user}',[UserController::class,'update'])->name('usuarios.update');
    Route::delete('usuarios/{user}',[UserController::class,'destroy'])->name('usuarios.delete');


    Route::get('modulos',[ModuleController::class,'index'])->name('modulos.view');
    Route::get('modulos/create',[ModuleController::class,'create'])->name('modulos.create');
    Route::post('modulos',[ModuleController::class,'store'])->name('modulos.store');
    Route::get('modulos/{module}/edit',[ModuleController::class,'edit'])->name('modulos.edit');
    Route::put('modulos/{module}',[ModuleController::class,'update'])->name('modulos.update');
    Route::delete('modulos/{module}',[ModuleController::class,'destroy'])->name('modulos.delete');


    Route::post('modulos/{module}/submodules',[SubModuleController::class,'store'])
        ->name('modulos.submodules.store');

    Route::put('submodules/{submodule}',[SubModuleController::class,'update'])
        ->name('modulos.submodules.update');

    Route::delete('submodules/{submodule}',[SubModuleController::class,'destroy'])
        ->name('modulos.submodules.delete');


    Route::get('roles',[RoleController::class,'index'])->name('roles.view');

});



/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])
->prefix('productos')
->name('productos.')
->group(function(){

    Route::get('productos',[ProductoController::class,'index'])->name('productos.view');

    Route::get('depositos',[DepositoController::class,'index'])->name('depositos.view');

    Route::get('clasificaciones',[ClasificacionController::class,'index'])->name('clasificaciones.view');

    Route::get('stock',[StockController::class,'index'])->name('stock.view');

    Route::get('{producto_id}/stock',[StockProductoController::class,'index'])->name('producto.stock.view');

    Route::post('{producto_id}/stock/store',[StockProductoController::class,'store'])->name('producto.stock.store');

    Route::get('movimientos-stock',[MovimientoStockController::class,'index'])->name('movimientos.stock.view');

});

Route::middleware(['auth'])->group(function(){

    // 🆕 SOLO SUPERADMIN
    Route::get('/empresa', function(){
        return view('empresa.index');
    })->name('empresa.index');

});

/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])
->prefix('clientes')
->name('clientes.')
->group(function(){

    Route::get('clientes',[ClienteController::class,'index'])->name('clientes.view');
    Route::get('clientes/create',[ClienteController::class,'create'])->name('clientes.create');
    Route::post('clientes',[ClienteController::class,'store'])->name('clientes.store');
    Route::get('clientes/{cliente}/edit',[ClienteController::class,'edit'])->name('clientes.edit');
    Route::put('clientes/{cliente}',[ClienteController::class,'update'])->name('clientes.update');
    Route::delete('clientes/{cliente}',[ClienteController::class,'destroy'])->name('clientes.delete');

});



/*
|--------------------------------------------------------------------------
| MESAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])
->prefix('mesas')
->name('mesas.')
->group(function(){

    Route::get('mesas',[MesaController::class,'index'])->name('mesas.view');
    Route::get('mesas/create',[MesaController::class,'create'])->name('mesas.create');
    Route::post('mesas',[MesaController::class,'store'])->name('mesas.store');
    Route::get('mesas/{mesa}/edit',[MesaController::class,'edit'])->name('mesas.edit');
    Route::put('mesas/{mesa}',[MesaController::class,'update'])->name('mesas.update');
    Route::delete('mesas/{mesa}',[MesaController::class,'destroy'])->name('mesas.delete');

});



/*
|--------------------------------------------------------------------------
| VENTAS / POS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])
->prefix('ventas')
->name('ventas.')
->group(function(){

    /*
    |---------------------------
    | CAJAS (catalogo)
    |---------------------------
    */
    Route::get('cajas',[CajaController::class,'index'])->name('cajas.index');
    Route::get('cajas/create',[CajaController::class,'create'])->name('cajas.create');
    Route::post('cajas',[CajaController::class,'store'])->name('cajas.store');
    Route::get('cajas/{caja}/edit',[CajaController::class,'edit'])->name('cajas.edit');
    Route::put('cajas/{caja}',[CajaController::class,'update'])->name('cajas.update');
    Route::delete('cajas/{caja}',[CajaController::class,'destroy'])->name('cajas.delete');


    /*
    |---------------------------
    | SESIONES DE CAJA
    |---------------------------
    */
    Route::get('cajas/abrir',[CajaSesionController::class,'create'])->name('cajas.abrir');
    Route::post('cajas/abrir',[CajaSesionController::class,'store'])->name('cajas.storeSesion');

    Route::get('cajas/dashboard',[CajaSesionController::class,'dashboard'])->name('cajas.dashboard');

    Route::get('cajas/cerrar',[CajaSesionController::class,'cerrar'])->name('cajas.cerrar');
    Route::post('cajas/cerrar',[CajaSesionController::class,'cerrarStore'])->name('cajas.cerrar.store');


    /*
    |---------------------------
    | HISTORIAL DE CAJAS
    |---------------------------
    */
    Route::get('cajas/historial',[CajaSesionController::class,'historial'])
        ->name('cajas.historial');

    Route::get('cajas/historial/{caja}',[CajaSesionController::class,'detalle'])
        ->name('cajas.historial.detalle');
    Route::get(
        'cajas/movimiento',
        [CajaSesionController::class, 'movimiento']
    )->name('cajas.movimiento');

    Route::post(
        'cajas/movimiento',
        [CajaSesionController::class,'storeMovimiento']
    )->name('cajas.movimiento.store');

    /*
    |---------------------------
    | POS RESTAURANTE
    |---------------------------
    */
    Route::get('pos',[PosController::class,'index'])->name('pos.index');

    Route::get('pos/mesa/{mesa}',[PosController::class,'mesa'])->name('pos.mesa');


    /*
    |---------------------------
    | POS DIRECTO
    |---------------------------
    */
    Route::get('pos/directa',[PosController::class,'ventaDirecta'])
        ->name('pos.directa.crear');

    Route::get('pos/directa/{venta}',function($venta){

        return view('ventas.pos.directa',[
            'venta' => \App\Models\Venta::findOrFail($venta)
        ]);

    })->name('pos.directa');


    /*
    |---------------------------
    | PAGO POS
    |---------------------------
    */
    Route::get('pos/pagar/{venta}',[PagoController::class,'index'])->name('pos.pagar');
    Route::post('pos/pagar/{venta}',[PagoController::class,'store'])->name('pos.pagar.store');


    /*
    |---------------------------
    | HISTORIAL DE VENTAS
    |---------------------------
    */
    Route::get('historial',[VentaController::class,'index'])->name('historial.index');

    Route::get('historial/{venta}',[VentaController::class,'show'])->name('historial.show');

    Route::post('historial/{venta}/anular',[VentaController::class,'anular'])->name('historial.anular');

    //IMPRESION DE COMPROBANTE
    Route::get('{id}/print', [VentaController::class, 'print'])
        ->name('print');


});


Route::middleware(['auth'])->prefix('reportes')->name('reportes.')->group(function () {

    Route::view('/margen', 'reportes.margen')->name('margen');
    Route::view('/rentables', 'reportes.rentables')->name('rentables');
    Route::view('/mas-vendidos', 'reportes.mas_vendidos')->name('mas_vendidos');
    Route::view('/tendencia', 'reportes.tendencia')->name('tendencia');
    Route::view('/horas', 'reportes.horas')->name('horas');
    Route::view('/dias', 'reportes.dias')->name('dias');
    Route::view('/ticket', 'reportes.ticket')->name('ticket');
    Route::view('/sin-rotacion', 'reportes.sin_rotacion')->name('sin_rotacion');
    Route::view('/stock-critico', 'reportes.stock_critico')->name('stock_critico');
    Route::view('/utilidad', 'reportes.utilidad')->name('utilidad');

});



Route::get('/asistente', [AsistenteController::class,'index'])->name('asistente');

Route::post('/asistente/procesar', [AsistenteController::class,'procesar'])->name('asistente.procesar');

Route::get('/reportes-ia',[ReportesIAController::class,'index'])->name('reportes.ia');

Route::post('/reportes-ia/consultar',[ReportesIAController::class,'consultar'])->name('reportes.ia.consultar');

Route::get('/proveedores', [ProveedorController::class, 'index'])
    ->name('proveedores.index');


Route::middleware(['auth'])->group(function () {

    Route::get('/seleccionar-sucursal', [SucursalSeleccionController::class, 'index'])
        ->name('seleccionar.sucursal');

    Route::post('/seleccionar-sucursal', [SucursalSeleccionController::class, 'seleccionar'])
        ->name('seleccionar.sucursal.store');
});

Route::get('/sucursales', [SucursalController::class, 'index'])
    ->name('sucursales.index');


    Route::prefix('compras')->group(function () {

        Route::get('/', [CompraController::class, 'index'])
            ->name('compras.index');

    });




require __DIR__.'/auth.php';