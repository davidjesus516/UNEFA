<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CursoController extends Controller
{
    /**
     * Muestra la lista de cursos.
     */
    public function index()
    {
        // Datos de prueba (Reemplazar con App\Models\Curso::all() cuando uses la BD)
        $cursos = [
            ['id' => 1, 'nombre' => 'Matemáticas Aplicadas I', 'codigo' => 'MA101'],
            ['id' => 2, 'nombre' => 'Programación Web con React', 'codigo' => 'PW203'],
            ['id' => 3, 'nombre' => 'Bases de Datos con PostgreSQL', 'codigo' => 'BD305'],
            ['id' => 4, 'nombre' => 'Arquitectura de Computadoras', 'codigo' => 'AC401'],
        ];

        // Renderiza el componente Cursos/Index.jsx y le pasa el array $cursos
        return Inertia::render('Cursos/Index', [
            'cursos' => $cursos,
        ]);
    }
}