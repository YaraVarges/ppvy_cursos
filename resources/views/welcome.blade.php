@extends('layouts.layout')

@section('title', 'Página inicial')

@section('header')
    @parent
    <div class="jumbotron">
        <h1 class="display-4">Bem vindo ao PPVY Cursos!</h1>
        <p class="lead">Somos uma plataforma de cursos online para desenvolvimento de softwares</p>
        <hr class="my-4">
        <p>Temos cursos focados na aprendizagem do backend, do frontend e de banco de dados</p>
        <a class="btn btn-primary btn-lg" href="{{ @route('cursos_lista') }}" role="button">Para ver nossos cursos, clique aqui</a>
    </div>
@endsection
