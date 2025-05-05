<?php
namespace codigo\brigit\includes\formularios;
use codigo\brigit\includes\formularios\Formulario;
use codigo\brigit\includes\users\userAppService;
use codigo\brigit\includes\users\userDTO;

class FormularioLogin extends Formulario
{
    private $redirect = null;
    public function __construct() 
    {
        parent::__construct('loginForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombreUsuario = '';

        if (isset($_POST['redirect'])) {
            $this->redirect = $_POST['redirect'];
        }
        
        if ($datos) 
        {
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Login</legend>
            <p><label>Nombre:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario"/></p>
            <p><label>Password:</label> <input type="password" name="password" /></p>
            <div class="buttonform"><button id="login" type="submit" name="login">Entrar</button></div>
        </fieldset>
EOF;
        return $html;
    }
    
    protected function Process($datos)
    {
        $result = array();
        
        //filter_var vs htmlspecialchars(trim(strip_tags($_REQUEST["username"])));

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
        if ( empty($nombreUsuario) ) 
        {
            $result[] = "El nombre de usuario no puede estar vacío";
        }
        
        $password = trim($datos['password'] ?? '');
        
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ( empty($password) ) 
        {
            $result[] = "El password no puede estar vacío.";
        }
        
        if (count($result) === 0) 
        {
            $userDTO = new userDTO(0, $nombreUsuario, $password);

            $userAppService = userAppService::GetSingleton();

            $foundedUserDTO = $userAppService->login($userDTO);

            if ( ! $foundedUserDTO ) 
            {
                // No se da pistas a un posible atacante
                $result[] = "El usuario o el password no coinciden";
            } 
            else 
            {
                $_SESSION["login"] = true;
                $_SESSION["nombre"] = $nombreUsuario;

                if ($this->redirect != null) {
                    $result = $this->redirect;
                } else {
                    $result = 'index.php';
                }
                $result = 'index.php';
            }
        }
        return $result;
    }
}