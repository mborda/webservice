<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
    private $libros = [
        [
            'id' => 1,
            'titulo' => "Jim Botón y Lucas el maquinista",
            'autor'=> "Michael Ende"
        ],
        [
            'id' => 2,
            'titulo' => "Jim Botón y los trece salvajes",
            'autor'=> "Michael Ende"
        ]

    ];

    /**
     * @Route("/libros", name="libros")
     */
    public function index()
    {
        $libros = $this->libros;
        return $this->json($libros);
    }

    /**
     * @Route("/libros/search/id/{id}")
     */
    public function searchById($id)
    {
        $libros = array_filter($this->libros, function($el) use ($id) {
            return $el["id"] == $id;
        });
        return $this->json($libros);
    }

    /**
     * @Route("/libros/search/author/{autor}")
     */
    public function searchByAuthor($autor)
    {
        $libros = array_filter($this->libros, function($el) use ($autor) {
            return strpos($el["autor"], $autor) !== false;
        });
        return $this->json($libros);
    }

    /**
     * @Route("/libros/search")
     */
    public function search(Request $request)
    {
        $filtros = json_decode($request->get("filters"));
        $libros = $this->libros;
        foreach ($filtros as $clave => $valor) {
            $libros = array_filter($this->libros, function($el) use ($clave, $valor) {
                return strpos($el[$clave], $valor) !== false;
            });
        }
        
        return $this->json($libros);
    }
}
