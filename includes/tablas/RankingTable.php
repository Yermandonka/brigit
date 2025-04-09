<?php
namespace codigo\brigit\includes\tablas;
use codigo\brigit\includes\palabras\WordAppService;
class RankingTable
{
    public function __construct()
    {
    }


    private function mostrarLista()
    {
        $wordAppService = wordAppService::GetSingleton();
        $words = $wordAppService->getAllWords();

        $filas = "";
        foreach ($words as $w) {
            $filas .= "<tr>
            <td>{$w->palabra()}</td>
            <td>{$w->significado()}</td>
            <td>{$w->creador()}</td>
            <td>{$w->votos()}</td>
        </tr>";
        }
        return $filas;
    }
    public function manage()
    {

        $html = <<<EOF
    <h1>Lista de Palabras</h1>
    <table>
        <thead>
            <tr>
                <th>Palabra</th>
                <th>Significado</th>
                <th>Creador</th>
                <th>Votos</th>
            </tr>
        </thead>
        <tbody>
EOF;
        $html .= $this->mostrarLista(); // Agregas la lista aquí
        $html .= <<<EOF
        </tbody>
    </table>
EOF;

        return $html;
    }


}