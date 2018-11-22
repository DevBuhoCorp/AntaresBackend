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

    //Área
    $router->get('area', ["uses" => "AreaController@index"]);
    $router->get('area_combo/{id}', ["uses" => "AreaController@combo"]);
    $router->get('area/{id}', ['uses' => 'AreaController@show']);
    $router->post('area', ['uses' => 'AreaController@store']);
    $router->put('area/{id}', ['uses' => 'AreaController@update']);
    $router->delete('area/{id}', ['uses' => 'AreaController@destroy']);

    //Departamento
    $router->get('departamento', ["uses" => "DepartamentoController@index"]);
    $router->get('departamento/{id}', ['uses' => 'DepartamentoController@show']);
    $router->post('departamento', ['uses' => 'DepartamentoController@store']);
    $router->put('departamento/{id}', ['uses' => 'DepartamentoController@update']);
    $router->delete('departamento/{id}', ['uses' => 'DepartamentoController@destroy']);
    $router->get('departamento_combo', ["uses" => "DepartamentoController@combo"]);

    //Cargo  
    $router->get('cargo', ["uses" => "CargoController@index"]);
    $router->get('cargo_combo', ["uses" => "CargoController@combo"]);
    $router->get('cargo/{id}', ['uses' => 'CargoController@show']);
    $router->post('cargo', ['uses' => 'CargoController@store']);
    $router->put('cargo/{id}', ['uses' => 'CargoController@update']);
    $router->delete('cargo/{id}', ['uses' => 'CargoController@destroy']);

    //Colaborador
    $router->get('colaborador', ["uses" => "ColaboradorController@index"]);
    $router->get('colaboradorarea', ["uses" => "ColaboradorController@colaboradorarea"]);
    $router->get('colaborador/{id}', ['uses' => 'ColaboradorController@show']);
    $router->get('colaboradorareashow/{id}', ['uses' => 'ColaboradorController@colaboradorareashow']);
    $router->post('colaborador', ['uses' => 'ColaboradorController@store']);
    $router->put('colaboradorarea/{id}', ['uses' => 'ColaboradorController@colaboradorareaupd']);
    $router->put('colaborador/{id}', ['uses' => 'ColaboradorController@update']);
    $router->delete('colaborador/{id}', ['uses' => 'ColaboradorController@destroy']);


});