<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    public function listaPorAluno(Request $request)
    {
        //na aplicação real, pegaria o usuário atual (que está logado no sistema),
        // como é para fins de estudo, iremos assumir que o aluno logado é o 1

        $sql = 'SELECT m.id AS id, m.status AS matricula_status, DATE_FORMAT(m.data_matricula, \'%d/%m/%Y\') AS data_matricula,
            c.nome AS curso_nome, c.id as curso_id FROM matricula m
            INNER JOIN curso c ON m.curso_id = c.id
            INNER JOIN aluno a ON m.aluno_id = a.id
            WHERE m.aluno_id = 1';

        if ($request->filled('curso_nome')) {
            $curso_nome = $request->get('curso_nome');
            $sql .= " AND c.nome LIKE '%{$curso_nome}%'";
        }

        $parametros = [];

        if ($request->filled('status')) {
            switch ($request->get('status')) {
                case 'em_andamento':
                    $status = 'Em andamento';
                    break;
                case 'concluida':
                    $status = 'Concluída';
                    break;
                case 'cancelada':
                    $status = 'Cancelada';
                    break;
                default:
                    $status = '';
                    break;
            }

            $sql .= ' AND m.status = :status';
            $parametros = ['status' => $status];
        }

        $matriculas = DB::select($sql, $parametros);

        $areas_por_curso = DB::select('SELECT c.id AS curso_id, c.nome AS curso_nome, a.nome as area_nome FROM pertence_a p
            INNER JOIN curso c ON p.curso_id = c.id
            INNER JOIN area_de_conhecimento a ON p.area_de_conhecimento_id = a.id;');

        $cursos_areas = [];

        //agrupando os cursos com as áreas
        foreach ($areas_por_curso as $area_por_curso) {
            if (!isset($cursos_areas[$area_por_curso->curso_id])) {
                $cursos_areas[$area_por_curso->curso_id]['curso'] = [
                    'id' => $area_por_curso->curso_id,
                    'nome' => $area_por_curso->curso_nome,
                ];
                $cursos_areas[$area_por_curso->curso_id]['areas'][] = $area_por_curso->area_nome;
            } else {
                $cursos_areas[$area_por_curso->curso_id]['areas'][] = $area_por_curso->area_nome;
            }
        }

        $cursos = DB::select('SELECT * FROM curso WHERE disponivel = 1'); //para modal de criação

        return view('matriculas.listaPorAluno',
            [
                'matriculas' => $matriculas,
                'cursos_areas' => $cursos_areas,
            ]
        );
    }

    public function matricular(Request $request)
    {
        $curso_id = $request->input('curso');

        if ($curso_id) {
            $existe_matricula = DB::select("SELECT * FROM matricula WHERE curso_id = :curso_id AND aluno_id = :aluno_id AND status = 'Em andamento'",
                [
                    'curso_id' => $curso_id,
                    'aluno_id' => 1, //em uma aplicação real, pegaria o usuário atual
                ]
            );

            if (empty($existe_matricula)) {
                DB::insert('INSERT INTO matricula (status, aluno_id, curso_id, data_matricula)
                            VALUES (:status, :aluno_id, :curso_id, NOW())',
                    [
                        'status' => 'Em andamento',
                        'aluno_id' => 1,
                        'curso_id' => $curso_id,
                    ]
                );

                return redirect()->route('matriculas_listaPorAluno')->with('success', 'Matricula realizada com sucesso');
            } else {
                return redirect()->route('matriculas_listaPorAluno')->with('warning', 'Você já possui uma matrícula em andamento para esse curso');
            }
        }

        return redirect()->route('matriculas_listaPorAluno');
    }

    public function cancelarMatricula(Request $request)
    {
        $id = $request->get('id');

        $existe = DB::select('SELECT * FROM matricula WHERE id = :id AND aluno_id = :aluno_id',
            [
                'id' => $id,
                'aluno_id' => 1, //verificação para caso alterem o ID da URL, para não cancelar uma matrícula de outro aluno
            ]
        );

        if ($existe) {
            DB::update("UPDATE matricula SET status = 'Cancelada' WHERE id = :id", ['id' => $id]);

            return redirect()->route('matriculas_listaPorAluno')->with('success', 'Matricula cancelada com sucesso');
        }

        return redirect()->route('matriculas_listaPorAluno');
    }
}
