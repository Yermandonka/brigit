<?php
namespace codigo\brigit\includes\tables;
use codigo\brigit\includes\words\wordAppService;
use codigo\brigit\includes\meanings\meaningAppService;
use codigo\brigit\includes\votes\voteAppService;
class WordTable
{
    public function __construct()
    {
    }

    private function mostrarLista($palabra = null)
    {
        $meaningAppService = meaningAppService::GetSingleton();
        $meanings = $meaningAppService->getAllMeanings($palabra);
        $filas = "";
        $contador = 1;

        $usuarioLogueado = isset($_SESSION["login"]) && ($_SESSION["login"] === true);
        $voter = $_SESSION['nombre'] ?? '';

        foreach ($meanings as $m) {
            $meanings = $meaningAppService->getAllMeanings($m->palabra());
            $votes = $meaningAppService->getAllVotes($m->palabra());
            $significado = $this->limitarTexto($meanings[0]->significado(), 80);

            // Obtener el voto actual del usuario para este significado
            $voteAppService = voteAppService::GetSingleton();
            $meaningId = $meaningAppService->getMeaningId($m->palabra(), $significado);
            $votoActual = $usuarioLogueado ? $voteAppService->getUserVote($voter, $meaningId) : null;

            // Modificar el estilo de los botones según el voto actual
            $estiloBotonLike = (!$usuarioLogueado || $votoActual === 'like')
                ? "style='opacity:0.5; cursor:not-allowed;' disabled" : "";
            $estiloBotonDislike = (!$usuarioLogueado || $votoActual === 'dislike')
                ? "style='opacity:0.5; cursor:not-allowed;' disabled" : "";

            $tooltipTitle = !$usuarioLogueado ? "title='Debes iniciar sesión para votar'" : "";

            $onClickLike = (!$usuarioLogueado) ? ""
                : "onclick='votar(\"{$m->palabra()}\", \"{$significado}\", \"like\", this)'";
            $onClickDislike = (!$usuarioLogueado) ? ""
                : "onclick='votar(\"{$m->palabra()}\", \"{$significado}\", \"dislike\", this)'";

            $filas .= "<tr class='filaRankingTable' id='{$m->palabra()}' onclick='mostrarFicha(\"{$m->palabra()}\", \"{$significado}\", \"{$m->creador()}\")' style='cursor: pointer;'>
        <td>{$contador}</td>
        <td>{$m->significado()}</td>
        <td>{$m->creador()}</td>
        <td>{$m->votos()}</td>
        <td class='reacciones'>
            <button type='button' name='accion' value='like' class='btn-like' {$estiloBotonLike} {$tooltipTitle} {$onClickLike}>👍</button>
            <button type='button' name='accion' value='dislike' class='btn-dislike' {$estiloBotonDislike} {$tooltipTitle} {$onClickDislike}>👎</button>
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

    public function manage($palabra = null)
    {
        $html = <<<EOF

    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Significado</th>
                <th>Creador</th>
                <th>Votos</th>
                <th>Reacciones</th>
            </tr>
        </thead>
        <tbody>
EOF;
        $html .= $this->mostrarLista($palabra); // Agregas la lista aquí
        $html .= <<<EOF
        </tbody>
    </table>
EOF;

        return $html;
    }


}


