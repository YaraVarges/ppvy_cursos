@extends('layouts.layout')
@section('title', 'Listagem de matrículas')

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
            <a href="" class="btn btn-info">Realizar matrícula</a>
        </div>
    </div>

    <form method="GET">
        <div class="row mt-3 mb-3 align-items-center">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="nome_do_curso">Nome do curso</label>
                    <input type="text" class="form-control" id="nome_do_curso" name="curso_nome"
                           value="{{ app('request')->get('curso_nome') }}">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value=""></option>
                        <option value="em_andamento" @if(app('request')->get('status')=='em_andamento') selected @endif>
                            Em andamento
                        </option>
                        <option value="concluida" @if(app('request')->get('status')=='concluida') selected @endif>
                            Concluída
                        </option>
                        <option value="cancelada" @if(app('request')->get('status')=='cancelada') selected @endif>
                            Cancelada
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group submit-filter">
                    <input type="submit" value="Filtrar" class="btn btn-dark">
                </div>
            </div>

        </div>
    </form>

    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Curso</th>
                <th scope="col">Áreas</th>
                <th scope="col">Status</th>
                <th scope="col">Data da matrícula</th>
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula->id }}</td>
                    <td>{{ $matricula->curso_nome }}</td>
                    <td>
                        @foreach($cursos_areas[$matricula->curso_id]['areas'] as $area)
                            <div class="col">{{ $area }}</div>
                        @endforeach
                    </td>
                    <td>{{ $matricula->matricula_status }}</td>
                    <td>{{ $matricula->data_matricula }}</td>
                    <td>
                        @if($matricula->matricula_status != 'Cancelada')
                            <a href="{{ route('matriculas_cancelar', ['id' => $matricula->id]) }}" class="btn btn-danger">Cancelar matrícula</a>
                        @else
                            <a href="{{ route('matriculas_reativar', ['id' => $matricula->id]) }}" class="btn btn-success">Reativar matrícula</a>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
