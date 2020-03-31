<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function lista()
    {
        $cursos = DB::select('SELECT * FROM curso');

        return view('cursos.lista', ['cursos' => $cursos]);
    }

    public function criar(Request $request)
    {
        $nome = $request->input('nome');
        $qtd_alunos = $request->input('qtd_alunos');
        $disponivel = $request->input('disponivel', 0);
        $areas = $request->input('areas');

        if ($nome && $qtd_alunos && !empty($areas)) {
            DB::insert('INSERT INTO curso(nome, quantidade_alunos, disponivel) VALUES (:nome, :quantidade_alunos, :disponivel)',
                [
                    'nome' => $nome,
                    'quantidade_alunos' => $qtd_alunos,
                    'disponivel' => $disponivel,
                ]
            );

            $curso_id = DB::table('curso')->latest('id')->first()->id; //pegando o último curso inserido

            foreach ($areas as $area) {
                DB::insert('INSERT INTO pertence_a(area_de_conhecimento_id, curso_id) VALUES (:area_id, :curso_id)',
                    [
                        'area_id' => $area,
                        'curso_id' => $curso_id,
                    ]
                );
            }

            return redirect()->route('cursos_lista')->with('success', 'Curso criado com sucesso');
        } else {
            return redirect()->route('cursos_criar_form')->with('warning', 'Você não preencheu todos os campos');
        }
    }

    public function criarForm()
    {
        $areas = DB::select('SELECT * FROM area_de_conhecimento');

        return view('cursos.criar', ['areas' => $areas]);
    }

    public function editarForm(Request $request, $id)
    {
        $curso = DB::select('SELECT * FROM curso c WHERE c.id = :id', ['id' => $id]);

        if ($curso) {
            $areas = DB::select('SELECT * FROM area_de_conhecimento');

            $curso_areas = DB::select('SELECT p.area_de_conhecimento_id as area_id FROM pertence_a p
            INNER JOIN curso c ON p.curso_id = c.id
            WHERE c.id = :curso_id', ['curso_id' => $id]);

            $cursos_areas_ids = [];

            foreach ($curso_areas as $curso_area) {
                $cursos_areas_ids[] = $curso_area->area_id;
            }

            return view('cursos.editar', ['curso' => $curso[0], 'areas' => $areas, 'curso_areas' => $cursos_areas_ids]);
        }

        return redirect()->route('cursos_lista')->with('warning', 'Esse curso não existe.');
    }

    public function editar(Request $request, $id)
    {
        $nome = $request->input('nome');
        $qtd_alunos = $request->input('qtd_alunos');
        $disponivel = $request->input('disponivel', 0);
        $areas_ids = $request->input('areas');

        if ($id && $nome && $qtd_alunos && !empty($areas_ids)) {
            DB::update('UPDATE curso SET nome = :nome, quantidade_alunos = :quantidade_alunos, disponivel = :disponivel WHERE id = :id',
                [
                    'nome' => $nome,
                    'quantidade_alunos' => $qtd_alunos,
                    'disponivel' => $disponivel,
                    'id' => $id
                ]
            );

            $curso_areas = DB::select('SELECT p.area_de_conhecimento_id as area_id FROM pertence_a p
            INNER JOIN curso c ON p.curso_id = c.id
            WHERE c.id = :curso_id', ['curso_id' => $id]);

            $removeIds = [];
            $keepIds = [];

            foreach ($curso_areas as $curso_area) { //áreas do curso atual antes da edição
                if (!in_array($curso_area->area_id, $areas_ids)) { //se a área que já estava cadastrada não estiver nas áreas selecionadas na edição, remove
                    $removeIds[] = $curso_area->area_id; //areas para serem removidas da tabela 'pertence_a'
                } else {
                    $keepIds[] = $curso_area->area_id; //areas selecionadas que não foram alteradas
                }
            }

            foreach ($removeIds as $removeId) {
                $existe = DB::select('SELECT * FROM pertence_a WHERE area_de_conhecimento_id = :area_id AND curso_id = :curso_id',
                    [
                        'area_id' => $removeId,
                        'curso_id' => $id
                    ]
                );

                if (!empty($existe)) { //se existir a área no banco
                    DB::delete('DELETE FROM pertence_a WHERE area_de_conhecimento_id = :area_id AND curso_id = :curso_id',
                        [
                            'area_id' => $removeId,
                            'curso_id' => $id
                        ]
                    );
                }
            }

            foreach ($areas_ids as $area_id) {
                if (!in_array($area_id, $keepIds)) {
                    DB::insert('INSERT INTO pertence_a(area_de_conhecimento_id, curso_id) VALUES (:area_id, :curso_id)',
                        [
                            'area_id' => $area_id,
                            'curso_id' => $id,
                        ]
                    );
                }
            }

            return redirect()->route('cursos_lista')->with('success', 'Curso salvo com sucesso');
        }

        return redirect()->route('cursos_editar_form', ['id' => $id])
            ->with('warning', 'Você não preencheu todos os campos!');
    }

    public function excluir(Request $request, $id)
    {
        $curso = DB::select('SELECT * FROM curso WHERE id = :id', ['id' => $id]);

        if ($curso) {
            DB::delete('DELETE FROM curso WHERE id = :id', ['id' => $id]);


            return redirect()->route('cursos_lista')->with('success', "Curso \"{$curso[0]->nome}\" excluído com sucesso!");
        }

        return redirect()->route('cursos_lista');
    }
}
