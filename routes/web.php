<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/cursos')->group(function() {
    Route::get('/', 'CursoController@lista')->name('cursos_lista');
    Route::post('/criar', 'CursoController@criar')->name('cursos_criar');
    Route::get('/criar', 'CursoController@criarForm')->name('cursos_criar_form');
    Route::get('/editar/{id}', 'CursoController@editarForm')->name('cursos_editar_form');
    Route::post('/editar/{id}', 'CursoController@editar')->name('cursos_editar');
    Route::get('/excluir/{id}', 'CursoController@excluir')->name('cursos_excluir');
});

Route::prefix('/matriculas')->group(function() {
    Route::get('/aluno', 'MatriculaController@listaPorAluno')->name('matriculas_lista_por_aluno');
    Route::post('/matricular', 'MatriculaController@matricular')->name('matriculas_matricular');
    Route::get('/cancelar/{id}', 'MatriculaController@cancelarMatricula')->name('matriculas_cancelar');
    Route::get('/realizar-matricula', 'MatriculaController@realizarMatricula')->name('matriculas_realizar_matricula');
    Route::get('/reativar-matricula/{id}', 'MatriculaController@reativarMatricula')->name('matriculas_reativar');
});
