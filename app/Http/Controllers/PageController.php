<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

     public function about()
    {
        $miembros = [
            [
                "nombre" => "Javier Valenzuela",
                "foto" => "Javier_Valenzuela.png",
            ],
            [
                "nombre" => "Martha Cota",
                "foto" => "Martha_Cota.png",
            ],
            [
                "nombre" => "Ariadna Morales",
                "foto" => "Ariadna_Morales.png",
            ],
            [
                "nombre" => "Diana Verdugo",
                "foto" => "Diana_Verdugo.png",
            ],
            [
                "nombre" => "Fernanda Figueroa",
                "foto" => "Fernanda_Figueroa.png",
            ],
            [
                "nombre" => "Natali Liera",
                "foto" => "Natali_Liera.png",
            ],
            [
                "nombre" => "Yamileth Sepulveda",
                "foto" => "Yamileth_Sepulveda.png",
            ],
        ];

        return view('page.about', compact("miembros"));
    }

}
