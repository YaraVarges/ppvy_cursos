@extends('layouts.layout')
@section('title', 'Edição de curso')

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
            <input type="text" class="form-control" id="nome_curso"
                   name="nome" placeholder="Nome do curso" value="{{ $curso->nome }}">
        </div>
        <div class="form-group">
            <label for="qtd_alunos">Quantidade de alunos</label>
            <input type="number" class="form-control" name="qtd_alunos" id="qtd_alunos" placeholder="Ex: 100"
                   value="{{ $curso->quantidade_alunos }}">
        </div>
        <div class="form-group">
            <label for="areas">Área</label>
            <select class="form-control" name="areas[]" id="areas" multiple>
                @foreach($areas as $area)
                    <option @if(in_array($area->id, $curso_areas)) selected @endif value="{{ $area->id }}">{{ $area->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            Disponível:
            <div class="custom-control custom-radio">
                <input type="radio" id="disponivel_sim" class="custom-control-input" name="disponivel"
                       value="1" @if($curso->disponivel == 1) checked @endif>
                <label class="custom-control-label" for="disponivel_sim">Sim</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="disponivel_nao" class="custom-control-input" name="disponivel"
                       value="0" @if($curso->disponivel == 0) checked @endif>
                <label class="custom-control-label" for="disponivel_nao">Não</label>
            </div>
        </div>

        <div class="form-group d-flex">
            <input type="submit" value="Salvar" class="btn btn btn-lg btn-primary w-25"/>
        </div>
    </form>
@endsection
