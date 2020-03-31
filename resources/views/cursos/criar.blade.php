@extends('layouts.layout')
@section('title', 'Criação de curso')

@section('content')
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <form method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="nome_curso">Nome do curso</label>
            <input type="text" class="form-control" id="nome_curso" name="nome" placeholder="Nome do curso">
        </div>
        <div class="form-group">
            <label for="qtd_alunos">Quantidade de alunos</label>
            <input type="number" class="form-control" name="qtd_alunos" id="qtd_alunos" placeholder="Ex: 100">
        </div>
        <div class="form-group">
            <label for="areas">Área</label>
            <select class="form-control" name="areas[]" id="areas" multiple>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            Disponível:
            <div class="custom-control custom-radio">
                <input type="radio" id="disponivel_sim" class="custom-control-input" name="disponivel" value="1" checked>
                <label class="custom-control-label" for="disponivel_sim">Sim</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="disponivel_nao" class="custom-control-input" name="disponivel" value="0">
                <label class="custom-control-label" for="disponivel_nao">Não</label>
            </div>
        </div>

        <div class="form-group d-flex">
            <input type="submit" value="Criar" class="btn btn btn-lg btn-primary w-25"/>
        </div>
    </form>
@endsection
