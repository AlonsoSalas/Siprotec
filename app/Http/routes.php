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

Route::get('home', 'HomeController@indexpro');

Route::controllers([
    'users' => 'UserController',
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('proyectos', 'ProyectosController');

Route::get('proyectos', 'ProyectosController@indexpro');

Route::get('proyectosEspe', 'ProyectosController@proyectosEspe');
Route::get('proyectosStatus', 'ProyectosController@proyectosStatus');
Route::get('proyectosFecha', 'ProyectosController@index');

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

Route::get('eliminarespe/{espe}',[
    'as' => 'eliminarespe', 'uses' => 'NewMetaController@eliminarespe'
]);

Route::get('editarproyecto/{id_proyecto}', [
    'as' => 'editarproyecto', 'uses' => 'NewMetaController@editar'
]);

Route::get('comentario/{id_proyecto}', [
    'as' => 'comentario', 'uses' => 'NewMetaController@comentario'
]);

Route::post('agregarcomentario/{id_proyecto}',[
    'as' => 'agregarcomentario', 'uses' => 'NewMetaController@agregarcomentario'
]);


Route::post('save',[
    'as' => 'save', 'uses' => 'NewMetaController@save'
]);

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

Route::get('descargarinforme/{filename}', [
    'as' => 'descargarinforme', 'uses' => 'NewMetaController@descargarinforme']);
Route::get('eliminarinforme/{filename}', [
    'as' => 'eliminarinforme', 'uses' => 'NewMetaController@eliminarinforme']);

Route::get('descargarindi/{filename}', [
    'as' => 'descargarindi', 'uses' => 'NewMetaController@descargarindi']);
Route::get('eliminarindi/{filename}', [
    'as' => 'eliminarindi', 'uses' => 'NewMetaController@eliminarindi']);

Route::get('reportes', 'ReportesController@index');

Route::get('especialistas', 'EspecialistasController@internos');

Route::get('proveedores', 'EspecialistasController@externos');

Route::get('eliminarproyect/{id}', [
    'as' => 'eliminarproyect', 'uses' => 'NewMetaController@eliminarproyect']);

Route::get('eliminarespein/{id}', [
    'as' => 'eliminarespein', 'uses' => 'EspecialistasController@eliminarespein']);

Route::post('agregarespein', [
    'as' => 'agregarespein', 'uses' => 'EspecialistasController@agregarespein']);

Route::get('eliminarespeex/{id}', [
    'as' => 'eliminarespeex', 'uses' => 'EspecialistasController@eliminarespeex']);

Route::post('agregarespeex', [
    'as' => 'agregarespeex', 'uses' => 'EspecialistasController@agregarespeex']);

Route::get('editarespeex/{id}', [
    'as' => 'editarespeex', 'uses' => 'EspecialistasController@editarespeex']);

Route::put('updateespeex/{id}', [
    'as' => 'updateespeex', 'uses' => 'EspecialistasController@updateespeex']);

Route::get('editarespein/{id}', [
    'as' => 'editarespein', 'uses' => 'EspecialistasController@editarespein']);

Route::put('updateespein/{id}', [
    'as' => 'updateespein', 'uses' => 'EspecialistasController@updateespein']);