<?php
namespace codigo\brigit\includes\tables;
use codigo\brigit\includes\words\wordAppService;
use codigo\brigit\includes\meanings\meaningAppService;
use codigo\brigit\includes\votes\voteAppService;

class myMeaningsTable
{
    public function __construct()
    {
    }
    private function mostrarLista()
    {
        $voter = $_SESSION['nombre'] ?? '';
        $meaningAppService = meaningAppService::GetSingleton();
        $meanings = $meaningAppService->getAllMeanings(null, $voter);
        $filas = "";
        $contador = 1;

        $usuarioLogueado = isset($_SESSION["login"]) && ($_SESSION["login"] === true);


        foreach ($meanings as $m) {
            $significado = $this->limitarTexto($m->significado(), 80);

            // Obtener el voto actual del usuario para este significado
            $voteAppService = voteAppService::GetSingleton();
            $meaningId = $meaningAppService->getMeaningId($m->palabra(), $significado);
            $votoActual = $usuarioLogueado ? $voteAppService->getUserVote($voter, $meaningId) : null;
            $noEsMio = $m->creador() !== $voter;

            $hayVariosSignificados = count($meanings) > 1;
            $contenidoSignificado = $hayVariosSignificados ? "Hay varios significados" : $significado;

            // Modificar el estilo de los botones según el voto actual
            $estiloBotonLike = ($hayVariosSignificados || !$usuarioLogueado || $votoActual === 'like')
                ? "style='opacity:0.5; cursor:not-allowed;' disabled" : "";
            $estiloBotonDislike = ($hayVariosSignificados || !$usuarioLogueado || $votoActual === 'dislike')
                ? "style='opacity:0.5; cursor:not-allowed;' disabled" : "";
            $estiloBotonDelete = ($hayVariosSignificados || !$usuarioLogueado || $noEsMio)
                ? "style='display:none;' disabled" : "";

            $tooltipTitle = !$usuarioLogueado ? "title='Debes iniciar sesión para votar'" : "";

            $onClickLike = ($hayVariosSignificados || !$usuarioLogueado) ? ""
                : "onclick='votar(\"{$m->palabra()}\", \"{$significado}\", \"like\", this)'";
            $onClickDislike = ($hayVariosSignificados || !$usuarioLogueado) ? ""
                : "onclick='votar(\"{$m->palabra()}\", \"{$significado}\", \"dislike\", this)'";
            $onClickDelete = ($hayVariosSignificados || !$usuarioLogueado || $noEsMio) ? ""
                : "onclick='eliminar(\"{$m->palabra()}\", \"{$significado}\", this)'";


            $filas .= "<tr class='filaRankingTable' id='{$m->palabra()}' onclick='mostrarFicha(\"{$m->palabra()}\", \"{$significado}\", \"{$m->creador()}\")' style='cursor: pointer;'>
        <td>{$contador}</td>
        <td>{$m->palabra()}</td>
        <td>{$contenidoSignificado}</td>
        <td>{$m->creador()}</td>
        <td>{$m->votos()}</td>
        <td class='reacciones'>
            <button type='button' name='accion' value='like' class='btn-like' {$estiloBotonLike} {$tooltipTitle} {$onClickLike}>👍</button>
            <button type='button' name='accion' value='dislike' class='btn-dislike' {$estiloBotonDislike} {$tooltipTitle} {$onClickDislike}>👎</button>
            <button type='button' name='accion' value='delete' class='btn-delete' {$estiloBotonDelete} {$onClickDelete}>🗑️</button>
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
<div class="row rankingTable">
<div class="col">
        <div id="fichaContainer" style="display:none">
            <div id="fichaContent">                    
            </div>
        </div>
<div id="rankingTable">
    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Palabra</th>
                <th>Significado</th>
                <th>Creador</th>
                <th>Votos</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
EOF;
        $html .= $this->mostrarLista(); // Agregas la lista aquí
        $html .= <<<EOF
        </tbody>
    </table>
</div>
</div>
</div>
EOF;

        return $html;
    }


}


