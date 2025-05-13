<?php
namespace codigo\brigit\includes\tables;
use codigo\brigit\includes\words\wordAppService;
use codigo\brigit\includes\meanings\meaningAppService;
use codigo\brigit\includes\votes\voteAppService;

class RankingTable
{
    public function __construct()
    {
    }
    private function mostrarLista($word = null)
    {
        $wordAppService = wordAppService::GetSingleton();
        if ($word == null) {
            $words = $wordAppService->getAllWords();
            $meaningAppService = meaningAppService::GetSingleton();
        } else if ($word == "null") {
            $words = [];
        } else {
            $words = $wordAppService->getTheseWords($word);
            $meaningAppService = meaningAppService::GetSingleton();
        }
        $filas = "";
        $contador = 1;

        $usuarioLogueado = isset($_SESSION["login"]) && ($_SESSION["login"] === true);
        $voter = $_SESSION['nombre'] ?? '';

        foreach ($words as $w) {
            $meanings = $meaningAppService->getAllMeanings($w->palabra());
            $votes = $meaningAppService->getAllVotes($w->palabra());
            $significado = $this->limitarTexto($meanings[0]->significado(), 80);
            
            // Obtener el voto actual del usuario para este significado
            $voteAppService = voteAppService::GetSingleton();
            $meaningId = $meaningAppService->getMeaningId($w->palabra(), $significado);
            $votoActual = $usuarioLogueado ? $voteAppService->getUserVote($voter, $meaningId) : false;

            $hayVariosSignificados = count($meanings) > 1;
            $contenidoSignificado = $hayVariosSignificados ? "Hay varios significados" : $significado;
            
            // Modificar el estilo de los botones según el voto actual
            $estiloBotonLike = ($hayVariosSignificados || !$usuarioLogueado || $votoActual === 'like') 
                ? "style='opacity:0.5; cursor:not-allowed;' disabled" : "";
            $estiloBotonDislike = ($hayVariosSignificados || !$usuarioLogueado || $votoActual === 'dislike') 
                ? "style='opacity:0.5; cursor:not-allowed;' disabled" : "";
            
            $tooltipTitle = !$usuarioLogueado ? "title='Debes iniciar sesión para votar'" : "";
            
            $onClickLike = ($hayVariosSignificados || !$usuarioLogueado) ? "" 
                : "onclick='votar(\"{$w->palabra()}\", \"{$significado}\", \"like\", this)'";
            $onClickDislike = ($hayVariosSignificados || !$usuarioLogueado) ? "" 
                : "onclick='votar(\"{$w->palabra()}\", \"{$significado}\", \"dislike\", this)'";
            
            $filas .= "<tr class='filaRankingTable' id='{$w->palabra()}' onclick='mostrarFicha(\"{$w->palabra()}\", \"{$significado}\", \"{$w->creador()}\")' style='cursor: pointer;'>
        <td>{$contador}</td>
        <td>{$w->palabra()}</td>
        <td>{$contenidoSignificado}</td>
        <td>{$w->creador()}</td>
        <td>{$votes}</td>
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

    public function manage()
    {

        $html = <<<EOF
<div id="rankingTable">
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

    public function search($palabra)
    {
        $html = <<<EOF
<div id="fichaContainer" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); 
    background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.5); z-index:1000; max-width:80%;">
    <button onclick="ocultarFichaContainer()" 
        style="position:absolute; right:10px; top:10px; border:none; background:none; cursor:pointer;">✕</button>
    <div id="fichaContent"></div>
</div>

<div class="row resultSearch">
<div class="col">
<div id="rankingTable">
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
        $html .= $this->mostrarLista($palabra);
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


