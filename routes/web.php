<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('cotizacionmail', ['uses' => 'CotizacionController@email']);

$router->group(['middleware' => ['auth', 'valid']], function () use ($router) {

    #region Área
    $router->get('area', ["uses" => "AreaController@index"]);
    $router->get('area_combo/{id}', ["uses" => "AreaController@combo"]);
    $router->get('area/{id}', ['uses' => 'AreaController@show']);
    $router->post('area', ['uses' => 'AreaController@store']);
    $router->put('area/{id}', ['uses' => 'AreaController@update']);
    $router->delete('area/{id}', ['uses' => 'AreaController@destroy']);
    #endregion

    #region Pais
    $router->get('pais', ["uses" => "PaisController@index"]);
    $router->get('pais_combo', ["uses" => "PaisController@combo"]);
    $router->get('pais/{id}', ['uses' => 'PaisController@show']);
    $router->post('pais', ['uses' => 'PaisController@store']);
    $router->put('pais/{id}', ['uses' => 'PaisController@update']);
    $router->delete('pais/{id}', ['uses' => 'PaisController@destroy']);
    #endregion

    #region Ciudad
    $router->get('ciudad', ["uses" => "CiudadController@index"]);
    $router->get('ciudad_combo', ["uses" => "CiudadController@combo"]);
    $router->get('ciudad/{id}', ['uses' => 'CiudadController@show']);
    $router->post('ciudad', ['uses' => 'CiudadController@store']);
    $router->put('ciudad/{id}', ['uses' => 'CiudadController@update']);
    $router->delete('ciudad/{id}', ['uses' => 'CiudadController@destroy']);
    #endregion

    #region Departamento
    $router->get('departamento', ["uses" => "DepartamentoController@index"]);
    $router->get('departamento/{id}', ['uses' => 'DepartamentoController@show']);
    $router->post('departamento', ['uses' => 'DepartamentoController@store']);
    $router->put('departamento/{id}', ['uses' => 'DepartamentoController@update']);
    $router->delete('departamento/{id}', ['uses' => 'DepartamentoController@destroy']);
    $router->get('departamento_combo', ["uses" => "DepartamentoController@combo"]);
    #endregion

    #region Cargo
    $router->get('cargo', ["uses" => "CargoController@index"]);
    $router->get('cargo_combo', ["uses" => "CargoController@combo"]);
    $router->get('cargo/{id}', ['uses' => 'CargoController@show']);
    $router->post('cargo', ['uses' => 'CargoController@store']);
    $router->put('cargo/{id}', ['uses' => 'CargoController@update']);
    $router->delete('cargo/{id}', ['uses' => 'CargoController@destroy']);
    #endregion

    #region Colaborador
    $router->get('colaborador', ["uses" => "ColaboradorController@index"]);
    $router->get('colaborador_user', ["uses" => "ColaboradorController@colaborador_user"]);
    $router->get('colaboradorarea', ["uses" => "ColaboradorController@colaboradorarea"]);
    $router->get('colaborador/{id}', ['uses' => 'ColaboradorController@show']);
    $router->get('colaboradorareashow/{id}', ['uses' => 'ColaboradorController@colaboradorareashow']);
    $router->post('colaborador', ['uses' => 'ColaboradorController@store']);
    $router->put('colaboradorarea/{id}', ['uses' => 'ColaboradorController@colaboradorareaupd']);
    $router->put('colaborador/{id}', ['uses' => 'ColaboradorController@update']);
    $router->delete('colaborador/{id}', ['uses' => 'ColaboradorController@destroy']);
    #endregion

    #region Contribuyente
    $router->get('contribuyente', ["uses" => "ContribuyenteController@index"]);
    $router->get('contribuyente/{id}', ['uses' => 'ContribuyenteController@show']);
    $router->post('contribuyente', ['uses' => 'ContribuyenteController@store']);
    $router->put('contribuyente/{id}', ['uses' => 'ContribuyenteController@update']);
    $router->delete('contribuyente/{id}', ['uses' => 'ContribuyenteController@destroy']);
    $router->get('contribuyente_combo', ["uses" => "ContribuyenteController@combo"]);
    #endregion

    #region Tipo Emisor
    $router->get('tipoemisor', ["uses" => "TipoEmisorController@index"]);
    $router->get('tipoemisor/{id}', ['uses' => 'TipoEmisorController@show']);
    $router->post('tipoemisor', ['uses' => 'TipoEmisorController@store']);
    $router->put('tipoemisor/{id}', ['uses' => 'TipoEmisorController@update']);
    $router->delete('tipoemisor/{id}', ['uses' => 'TipoEmisorController@destroy']);
    $router->get('tipoemisor_combo', ["uses" => "TipoEmisorController@combo"]);
    #endregion

    #region Tipo Identificación
    $router->get('tipoidentificacion', ["uses" => "TipoIdentificacionController@index"]);
    $router->get('tipoidentificacion/{id}', ['uses' => 'TipoIdentificacionController@show']);
    $router->post('tipoidentificacion', ['uses' => 'TipoIdentificacionController@store']);
    $router->put('tipoidentificacion/{id}', ['uses' => 'TipoIdentificacionController@update']);
    $router->delete('tipoidentificacion/{id}', ['uses' => 'TipoIdentificacionController@destroy']);
    $router->get('tipoidentificacion_combo', ["uses" => "TipoIdentificacionController@combo"]);
    #endregion

    #region Proveedor
    $router->get('proveedor', ["uses" => "ProveedorController@index"]);
    $router->get('proveedorcombo', ["uses" => "ProveedorController@combo"]);
    $router->get('proveedor/{id}', ['uses' => 'ProveedorController@show']);
    $router->post('proveedor', ['uses' => 'ProveedorController@store']);
    $router->put('proveedor/{id}', ['uses' => 'ProveedorController@update']);
    $router->delete('proveedor/{id}', ['uses' => 'ProveedorController@destroy']);
    #endregion

    #region Presupuesto
    $router->get('presupuesto/{departamento}/{anio}', ["uses" => "PresupuestoController@show"]);
    $router->post('presupuesto/{departamento}/{anio}', ["uses" => "PresupuestoController@store"]);
    #endregion

    #region Items
    $router->get('items', ["uses" => "ItemController@index"]);
    $router->get('autocompleteitems', ["uses" => "ItemController@autocomplete"]);
    $router->get('items/{id}', ['uses' => 'ItemController@show']);
    $router->post('items', ['uses' => 'ItemController@store']);
    $router->put('items/{id}', ['uses' => 'ItemController@update']);
    $router->delete('items/{id}', ['uses' => 'ItemController@destroy']);
    #endregion

    #region Orden de Pedido
    $router->get('opedido', ["uses" => "OrdenPedidoController@index"]);
    $router->get('opedidoauth', ["uses" => "OrdenPedidoController@indexauth"]);
    $router->get('opedido/{id}', ['uses' => 'OrdenPedidoController@show']);
    $router->post('opedido', ['uses' => 'OrdenPedidoController@store']);
    $router->put('opedido/{id}', ['uses' => 'OrdenPedidoController@update']);
    $router->delete('opedido/{id}', ['uses' => 'OrdenPedidoController@destroy']);
    #endregion

    #region Detalle de Pedido
    $router->get('detallepedido', ["uses" => "DetalleOPController@index"]);
    $router->get('detallepedido/{id}', ['uses' => 'DetalleOPController@show']);
    $router->post('detallepedido', ['uses' => 'DetalleOPController@store']);
    $router->put('detallepedido/{id}', ['uses' => 'DetalleOPController@update']);
    $router->delete('detallepedido/{id}', ['uses' => 'DetalleOPController@destroy']);
    #endregion

    #region Bodega
    $router->get('bodega', ["uses" => "BodegaController@index"]);
    $router->get('bodega_combo', ["uses" => "BodegaController@combo"]);
    $router->get('bodega_list', ["uses" => "BodegaController@list"]);
    $router->get('bodega/{id}', ['uses' => 'BodegaController@show']);
    $router->post('bodega', ['uses' => 'BodegaController@store']);
    $router->put('bodega/{id}', ['uses' => 'BodegaController@update']);
    $router->delete('bodega/{id}', ['uses' => 'BodegaController@destroy']);
    #endregion

    #region Tipo Movimiento
    $router->get('tipomovimiento', ["uses" => "TipoMovimientoController@index"]);
    $router->get('tipomovimiento/{id}', ['uses' => 'TipoMovimientoController@show']);
    $router->post('tipomovimiento', ['uses' => 'TipoMovimientoController@store']);
    $router->put('tipomovimiento/{id}', ['uses' => 'TipoMovimientoController@update']);
    $router->delete('tipomovimiento/{id}', ['uses' => 'TipoMovimientoController@destroy']);
    $router->get('tipomovimiento_combo', ["uses" => "TipoMovimientoController@combo"]);
    #endregion

    #region Tipo Movimiento Reverso
    $router->get('tipomovimiento/reverso/{id}', ['uses' => 'TipoMovimientoReversoController@index']);
    $router->post('tipomovimiento/reverso/{movimiento}', ['uses' => 'TipoMovimientoReversoController@store']);
    #endregion

    #region Tipo Documento
    $router->get('tipodocumento', ["uses" => "TipoDocumentoController@index"]);
    $router->get('tipodocumento/{id}', ['uses' => 'TipoDocumentoController@show']);
    $router->post('tipodocumento', ['uses' => 'TipoDocumentoController@store']);
    $router->put('tipodocumento/{id}', ['uses' => 'TipoDocumentoController@update']);
    $router->delete('tipodocumento/{id}', ['uses' => 'TipoDocumentoController@destroy']);
    $router->get('tipodocumento_combo', ["uses" => "TipoDocumentoController@combo"]);
    #endregion

    #region Users
    $router->get('users_combo', ["uses" => "UsersController@combo"]);
    $router->get('usuariotmov/{user}', ["uses" => "UsersTipoMovimientoController@index"]);
    $router->post('usuariotmov/{user}', ["uses" => "UsersTipoMovimientoController@store"]);
    #endregion

    #region Bodega-TipoMovimiento
    $router->get('bodegatmov/{bodega}', ["uses" => "BodegaTipoMovimientoController@index"]);
    $router->post('bodegatmov/{bodega}', ["uses" => "BodegaTipoMovimientoController@store"]);
    #endregion

    #region Usuario
    $router->get('usuario', ['uses' => 'UsuarioController@index']);
    $router->get('usuario/{id}', ['uses' => 'UsuarioController@show']);
    $router->put('changepass/{userid}', ['uses' => 'UsuarioController@changepass']);
    $router->post('usuario', ['uses' => 'UsuarioController@store']);
//    $router->put('usuario/{userid}/{datosid}', ['uses' => 'UsuarioController@update']);
    $router->delete('usuario/{id}', ['uses' => 'UsuarioController@destroy']);
    #endregion

    #region Usuario-Bodega
    $router->get('usuario_bod/', ["uses" => "UsersBodegaController@combo"]);
    $router->get('usuario_bod/tmovimiento/', ["uses" => "UsersBodegaController@user_bodega_movimiento"]);
    $router->get('usuario_bod/{bodega}', ["uses" => "UsersBodegaController@index"]);
    $router->post('usuario_bod/{bodega}', ["uses" => "UsersBodegaController@store"]);
    #endregion

    #region Cotizacion
    $router->get('cotizacion', ['uses' => 'CotizacionController@index']);
    $router->get('cotizacion/{id}', ['uses' => 'CotizacionController@show']);
    $router->put('cotizacion/{id}', ['uses' => 'CotizacionController@update']);
    $router->post('cotizacion', ['uses' => 'CotizacionController@store']);
   
    $router->delete('cotizacion/{id}', ['uses' => 'CotizacionController@destroy']);
    #endregion

    #region DetalleCotizacion
    $router->get('detallecotizacion', ['uses' => 'DetalleCotController@index']);
    $router->get('detallecotizacion/{id}', ['uses' => 'DetalleCotController@show']);
    $router->put('detallecotizacion/{id}', ['uses' => 'DetalleCotController@update']);
    $router->post('detallecotizacion', ['uses' => 'DetalleCotController@store']);
    $router->delete('detallecotizacion/{id}', ['uses' => 'DetalleCotController@destroy']);
    #endregion

    #region Movimientos
    $router->get('bodega_productos/{bodega}', ["uses" => "MovimientoController@bodega_producto"]);
    #endregion

});

$router->get('/pdf', function () {
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->download('invoice.pdf');


//    PDF::SetTitle('Hello World');
//    PDF::AddPage();
//    PDF::Write(0, 'Hello World');
//    PDF::Output('hello_world.pdf');
});

