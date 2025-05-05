<?php

require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'About Us';

$contenidoPrincipal = <<<EOS
<div id="aboutUs">
    <h1>Sobre Nosotros</h1>
    <p>Nuestra plataforma web será un <strong>repositorio colaborativo de palabras</strong>. Una persona registrada con cierto rango podrá proponer nuevas palabras, que solo serán aceptadas si alcanzan un número mínimo de votaciones.</p>
    <p>Las palabras aprobadas se mostrarán en un <strong>ranking dinámico</strong>, donde se reflejará el <em>número de personas que han votado</em>, el contexto de uso y otras métricas relevantes. Este sistema permitirá evidenciar la necesidad de incorporar ciertos términos al lenguaje formal, mostrando <em>la urgencia de su reconocimiento por parte de la RAE</em>.</p>
    <p>Más que un simple diccionario, este repositorio será un espacio donde la comunidad podrá dar voz a la evolución del idioma, destacando la importancia de adaptarlo a los cambios culturales, morales y éticos.</p>
    <p>El lenguaje está vivo, y nuestra plataforma demostrará por qué algunas palabras merecen ser oficiales.</p>
</div>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';
