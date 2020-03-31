@extends('layouts.layout')

@section('title', 'Listagem de cursos')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <div class="row mt-3 mb-3">
        <div class="col">
            <a href="{{ route('cursos_criar') }}" class="btn btn-info">Adicionar novo</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Quantidade de Alunos</th>
            <th scope="col">Disponível</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cursos as $curso)
            <tr>
                <td>{{ $curso->id }}</td>
                <td>{{ $curso->nome }}</td>
                <td>{{ $curso->quantidade_alunos }}</td>
                <td>{{ $curso->disponivel }}</td>
                <td>
                    <a href="{{ route('cursos_editar', ['id' => $curso->id]) }}" class="btn btn-info">Editar</a>
                    <a href="{{ route('cursos_excluir', ['id' => $curso->id]) }}" class="btn btn-danger">Excluir</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
