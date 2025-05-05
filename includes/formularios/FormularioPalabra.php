<?php
namespace codigo\brigit\includes\formularios;
use codigo\brigit\includes\palabras\wordAlreadyExistException;
use codigo\brigit\includes\formularios\Formulario;
use codigo\brigit\includes\usuarios\userAppService;
use codigo\brigit\includes\palabras\wordAppService;
use codigo\brigit\includes\palabras\wordDTO;
use codigo\brigit\includes\Aplicacion;
class FormularioPalabra extends Formulario
{
    public function __construct() 
    {
        parent::__construct('wordForm');
    }
    
    protected function CreateFields($datos)
    {
        $html = <<<EOF
        <fieldset>
            <legend>Crea una palabra</legend>
            <p><label>Palabra:</label> <input type="text" name="palabra"/></p>
            <p><label>Significado:</label> <textarea type="text" name="significado" placeholder="Máximo 500 carácteres"/></textarea></p>
            <div class="buttonform"><button type="submit" name="crearPalabra">Crear</button></div>
        </fieldset>
        
EOF;
        return $html;
    }
    

    protected function Process($datos)
    {
        $result = array();
        
        $palabra = trim($datos['palabra'] ?? '');
        
        $palabra = filter_var($palabra, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( empty($palabra) ) 
        {
            $result[] = "La palabra no puede estar vacía";
        }

        if (strpos($palabra, ' ') !== false) {
            $result[] = "Solo puede ser una palabra.";
        }
        
        $significado = trim($datos['significado'] ?? '');
        
        $significado = filter_var($significado, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( empty($significado) ) 
        {
            $result[] = "El significado no puede estar vacío.";
        }

        if (strlen($significado) > 500) {
            $result[] = "El significado no puede tener más de 500 caracteres.";
        }
    
        if (count($result) === 0) 
        {
            try
            {
                $userAppService = userAppService::GetSingleton();

                $wordDTO = new wordDTO(0, $palabra, $significado, $_SESSION['nombre'], 0);

                $wordAppService = wordAppService::GetSingleton();

                $createdWordDTO = $wordAppService->create($wordDTO);

                $result = 'index.php';

                $app = Aplicacion::getInstance();
                
                $mensaje = "Se ha registrado exitosamente la palabra {$palabra}";
                
                $app->putAtributoPeticion('mensaje', $mensaje);
            }
            catch(wordAlreadyExistException $e)
            {
                $result[] = $e->getMessage();
            }
        }

        return $result;
    }
}