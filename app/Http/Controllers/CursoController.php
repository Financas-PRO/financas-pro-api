<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {

        $obj = new Curso();
        $curso = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $curso
        ];

    }
}
