<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Driver\Connection;

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
    public function index(Connection $connection)
    {
        $libros = $connection->fetchAll("SELECT * FROM libros");
        return $this->json($libros);
    }

    /**
     * @Route("/libros/search/id/{id}")
     */
    public function searchById(Connection $connection, $id)
    {
        $libros = $connection->fetchAll("SELECT * FROM libros WHERE id = $id");
        return $this->json($libros);
    }

    /**
     * @Route("/libros/search/author/{autor}")
     */
    public function searchByAuthor(Connection $connection, $autor)
    {
        $libros = $connection->fetchAll("SELECT * FROM libros WHERE autor LIKE '%$autor%'");
        return $this->json($libros);
    }

    /**
     * @Route("/libros/search")
     */
    public function search(Request $request, Connection $connection)
    {
        $filtros = json_decode($request->get("filters"));
        $libros = $connection->fetchAll("SELECT * FROM libros");
        foreach ($filtros as $clave => $valor) {
            $libros = array_filter($this->libros, function ($el) use ($clave, $valor) {
                return strpos(strtolower($el[$clave]), strtolower($valor)) !== false;
            });
        }
        
        return $this->json($libros);
    }
}
