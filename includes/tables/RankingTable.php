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
        $contador = 1;

        foreach ($words as $w) {
            $meanings = $meaningAppService->getAllMeanings($w->palabra());
            $votes = $meaningAppService->getAllVotes($w->palabra());
            $significado = $this->limitarTexto($meanings[0]->significado(), 80);

            $contenidoSignificado = (count($meanings) <= 1)
                ? $significado
                : "Hay varios significados";

            $filas .= "<tr>
        <td>{$contador}</td>
        <td>{$w->palabra()}</td>
        <td>{$contenidoSignificado}</td>
        <td>{$w->creador()}</td>
        <td>{$votes}</td>
        <td class='reacciones'>
                <button type='submit' name='accion' value='like' class='btn-like'>👍</button>
                <button type='submit' name='accion' value='dislike' class='btn-dislike'>👎</button>
        </td>
    </tr>";

            $contador++;
        }

        return $filas;
    }

    private function limitarTexto($texto, $limite = 100)
    {
        if (strlen($texto) > $limite) {
            $recortado = substr($texto, 0, $limite) . '...';
            return "<span class='resumen'>$recortado</span><span class='completo' style='display:none;'>$texto</span> <a href='#' class='ver-mas'>Leer más</a>";
        } else {
            return $texto;
        }
    }

    public function manage()
    {

        $html = <<<EOF
<div id="rankingTable">
    <h1>Lista de Palabras</h1>
    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Palabra</th>
                <th>Significado</th>
                <th>Creador</th>
                <th>Votos</th>
                <th>Reacciones</th>
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