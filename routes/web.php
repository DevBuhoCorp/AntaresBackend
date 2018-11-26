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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['middleware' => [ 'auth', 'valid' ] ], function () use ($router) {

    #region Área
    $router->get('area', ["uses" => "AreaController@index"]);
    $router->get('area_combo/{id}', ["uses" => "AreaController@combo"]);
    $router->get('area/{id}', ['uses' => 'AreaController@show']);
    $router->post('area', ['uses' => 'AreaController@store']);
    $router->put('area/{id}', ['uses' => 'AreaController@update']);
    $router->delete('area/{id}', ['uses' => 'AreaController@destroy']);
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
    $router->get('items/{id}', ['uses' => 'ItemController@show']);
    $router->post('items', ['uses' => 'ItemController@store']);
    $router->put('items/{id}', ['uses' => 'ItemController@update']);
    $router->delete('items/{id}', ['uses' => 'ItemController@destroy']);
    #endregion

    #region Orden de Pedido
    $router->get('opedido', ["uses" => "OrdenPedidoController@index"]);
    $router->get('opedido/{id}', ['uses' => 'OrdenPedidoController@show']);
    $router->post('opedido', ['uses' => 'OrdenPedidoController@store']);
    $router->put('opedido/{id}', ['uses' => 'OrdenPedidoController@update']);
    $router->delete('opedido/{id}', ['uses' => 'OrdenPedidoController@destroy']);
    #endregion




});