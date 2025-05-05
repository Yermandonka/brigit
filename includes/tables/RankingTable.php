<?php
namespace codigo\brigit\includes\tables;
use codigo\brigit\includes\words\wordAppService;
use codigo\brigit\includes\meanings\meaningAppService;
class RankingTable
{
    public function __construct()
    {
    }


    private function mostrarLista()
    {
        $wordAppService = wordAppService::GetSingleton();
        $words = $wordAppService->getAllWords();
        $meaningAppService = meaningAppService::GetSingleton();

        $filas = "";
        foreach ($words as $w) {
            $meanings = $meaningAppService->getAllMeanings($w->palabra());
            if (count($meanings) <= 1) {
                $filas .= "<tr>
            <td>{$w->palabra()}</td>
            <td>{$meanings}</td>
            <td>{$w->creador()}</td>
            <td>{$w->votos()}</td>
        </tr>";
            } else {
                $filas .= "<tr>
            <td>{$w->palabra()}</td>
            <td>Hay varios significados</td>
            <td>{$w->creador()}</td>
            <td>{$w->votos()}</td>
        </tr>";
            }
        }
        return $filas;
    }


    public function manage()
    {

        $html = <<<EOF
<div id="rankingTable">
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
</div>
EOF;

        return $html;
    }


}