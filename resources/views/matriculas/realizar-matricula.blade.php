@extends('layouts.layout')
@section('title', 'Realizar matrícula')

@section('content')
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <form method="POST" action="{{ route('matriculas_matricular') }}" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="curso">Curso</label>
            <select class="form-control" name="curso" id="curso">
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group d-flex">
            <input type="submit" value="Realizar matrícula" class="btn btn btn-lg btn-primary w-25"/>
        </div>
    </form>
@endsection
