<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContatoController;

Route::get('/', function () {
    return view('welcome');
});
// Rota GET, exibe o formulario e lista de contatos
Route::get('/', [ContatoController::class, 'index']);
// Rota POST, envia os dados do formulario para o banco de dados
Route::post('/save', [ContatoController::class, 'form']);

//Rota DELETE, remove o dado já salvo no banco
Route::delete('/delete/{id}', [ContatoController::class, 'delete']);

//Traz os dados do id que será alterado
Route::get('/edit/{id}', [ContatoController::class, 'edit']);

//Rota PUT recebe os dados alterados e atualiza no banco
Route::put('/update/{id}', [ContatoController::class, 'update']);