<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
    'users' => 'UserController',
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('proyectos', 'ProyectosController@index');

Route::resource('proyectos', 'ProyectosController');

Route::get('proyectos2', 'ProyectosController@Proyectos2');

Route::get('newincidencia', 'ProyectosController@newincidencia');

//Route::get('editarproyecto', 'NewMetaController@edit');

Route::resource('newmeta', 'NewMetaController');

Route::post('agregarproveedor',[
    'as' => 'agregarproveedor', 'uses' => 'NewMetaController@agregarproveedor'
]);

Route::post('asignarespecialista/{id_proyecto}',[
    'as' => 'asignarespecialista', 'uses' => 'NewMetaController@asignarespecialista'
]);

Route::post('asignarespecialistaex/{id_proyecto}',[
    'as' => 'asignarespecialistaex', 'uses' => 'NewMetaController@asignarespecialistaex'
]);

Route::get('eliminarprove/{id_proyecto}',[
    'as' => 'eliminarprove', 'uses' => 'NewMetaController@eliminarprove'
]);

Route::get('eliminarespe/{id_proyecto}',[
    'as' => 'eliminarespe', 'uses' => 'NewMetaController@eliminarespe'
]);

Route::get('editarproyecto/{id_proyecto}', [
    'as' => 'editarproyecto', 'uses' => 'NewMetaController@editar'
]);

Route::get('formulario','StorageController@index');

Route::post('save',[
    'as' => 'save', 'uses' => 'NewMetaController@save'
]);

//
//Route::post('fileentry/add',[
//    'as' => 'addentry', 'uses' => 'StorageController@add']);


Route::controller('uploads','UploadsController');

Route::get('FO-UCT-05', 'PdfController@reginci');

Route::get('FO-UCT-06', 'PdfController@matrzmetecs');

Route::get('FO-UCT-07', 'PdfController@reportind');

Route::get('FO-UCT-08', 'PdfController@infoavanc');

Route::get('FO-UCT-09', 'PdfController@invoice');

Route::get('FO-UCT-10', 'PdfController@seguientre');

Route::get('FO-UCT-11', 'PdfController@cumplimetesp');

Route::get('FO-UCT-12', 'PdfController@seguiprovee');

Route::get('descargarlev/{filename}', [
    'as' => 'descargarlev', 'uses' => 'NewMetaController@descargarlev']);
Route::get('eliminarlev/{filename}', [
    'as' => 'eliminarlev', 'uses' => 'NewMetaController@eliminarlev']);

Route::get('descargarfo/{filename}', [
    'as' => 'descargarfo', 'uses' => 'NewMetaController@descargarfo']);
Route::get('eliminarfo/{filename}', [
    'as' => 'eliminarfo', 'uses' => 'NewMetaController@eliminarfo']);

Route::get('descargarplan/{filename}', [
    'as' => 'descargarplan', 'uses' => 'NewMetaController@descargarplan']);
Route::get('eliminarplan/{filename}', [
    'as' => 'eliminarplan', 'uses' => 'NewMetaController@eliminarplan']);

Route::get('descargarcer/{filename}', [
    'as' => 'descargarcer', 'uses' => 'NewMetaController@descargarcer']);
Route::get('eliminarcer/{filename}', [
    'as' => 'eliminarcer', 'uses' => 'NewMetaController@eliminarcer']);

Route::get('descargarorden/{filename}', [
    'as' => 'descargarorden', 'uses' => 'NewMetaController@descargarorden']);
Route::get('eliminarorden/{filename}', [
    'as' => 'eliminarorden', 'uses' => 'NewMetaController@eliminarorden']);

Route::get('descargarfactura/{filename}', [
    'as' => 'descargarfactura', 'uses' => 'NewMetaController@descargarfactura']);
Route::get('eliminarfactura/{filename}', [
    'as' => 'eliminarfactura', 'uses' => 'NewMetaController@eliminarfactura']);

Route::get('reportes', 'ReportesController@index');

Route::get('eliminarproyect/{id}', [
    'as' => 'eliminarproyect', 'uses' => 'NewMetaController@eliminarproyect']);