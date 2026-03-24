<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class ClassroomProfessorController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('DOTNET_API_URL', 'http://profeluno_dotnet:9000');
    }

    public function index(Request $request)
    {
        // ── Dados fictícios ───────────────────────────────────────────────
        $collection = collect([
            [
                'id'               => 1,
                'titulo'           => 'Aula de Matemática',
                'materia'          => 'Matemática',
                'descricao'        => 'Revisão de equações do 2º grau e funções',
                'status'           => 'active',
                'qtd_alunos'       => 25,
                'avaliacao'        => 4.5,
                'material'         => true,
                'data_hora_inicio' => '2026-03-23T19:00:00',
            ],
            [
                'id'               => 2,
                'titulo'           => 'Aula de Física',
                'materia'          => 'Física',
                'descricao'        => 'Leis de Newton e dinâmica',
                'status'           => 'pending',
                'qtd_alunos'       => 18,
                'avaliacao'        => 4.2,
                'material'         => false,
                'data_hora_inicio' => '2026-03-24T20:00:00',
            ],
            [
                'id'               => 3,
                'titulo'           => 'Aula de História',
                'materia'          => 'História',
                'descricao'        => 'Segunda Guerra Mundial — causas e consequências',
                'status'           => 'completed',
                'qtd_alunos'       => 30,
                'avaliacao'        => 4.8,
                'material'         => true,
                'data_hora_inicio' => '2026-03-20T18:00:00',
            ],
            [
                'id'               => 4,
                'titulo'           => 'Aula de Química',
                'materia'          => 'Química',
                'descricao'        => 'Tabela periódica e ligações químicas',
                'status'           => 'pending',
                'qtd_alunos'       => 22,
                'avaliacao'        => 4.0,
                'material'         => true,
                'data_hora_inicio' => '2026-03-25T14:00:00',
            ],
            [
                'id'               => 5,
                'titulo'           => 'Aula de Português',
                'materia'          => 'Português',
                'descricao'        => 'Análise sintática e redação dissertativa',
                'status'           => 'completed',
                'qtd_alunos'       => 28,
                'avaliacao'        => 4.6,
                'material'         => true,
                'data_hora_inicio' => '2026-03-18T17:00:00',
            ],
        ]);

        // ── Converter para objeto + tratar datas ──────────────────────────
        $collection = $collection->map(function ($item) {
            $item = (object) $item;

            $item->data_hora_inicio = $item->data_hora_inicio
                ? Carbon::parse($item->data_hora_inicio)
                : null;

            return $item;
        });

        // ── Paginação ────────────────────────────────────────────────────
        $page = $request->get('page', 1);
        $perPage = 10;

        $salas = new LengthAwarePaginator(
            $collection->forPage($page, $perPage)->values(),
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url()]
        );

        // ── Filtros ──────────────────────────────────────────────────────
        $salasAtivas     = $collection->where('status', 'active')->values();
        $salasAgendadas  = $collection->where('status', 'pending')->values();
        $salasConcluidas = $collection->where('status', 'completed')->values();
        $salaAtiva       = $salasAtivas->first();

        return view('professor.salas.index', compact(
            'salas',
            'salasAtivas',
            'salasAgendadas',
            'salasConcluidas',
            'salaAtiva',
        ));
    }

    public function create()
    {
        return view('professor.salas.create');
    }
}