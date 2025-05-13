<?php
namespace codigo\brigit\includes\formularios;
use codigo\brigit\includes\formularios\Formulario;
use codigo\brigit\includes\users\userAppService;
use codigo\brigit\includes\users\userDTO;
use codigo\brigit\includes\users\userAlreadyExistException;
use codigo\brigit\includes\Aplicacion;
class FormularioRegistro extends Formulario
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombreUsuario = '';
        
        if ($datos) 
        {
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Registrarse</legend>
            <p><label>Nombre:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario" autofocus required></p>
            <p><label>Password:</label> <input type="password" name="password" /></p>
            <p><label>Re-Password:</label> <input type="password" name="rePassword" /></p>
            <div class="buttonform"><button type="submit" name="login">Entrar</button></div>
        </fieldset>
EOF;
        return $html;
    }
    

    protected function Process($datos)
    {
        $result = array();
        
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

        $rePassword = trim($datos['rePassword'] ?? '');
        
        $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($password !== $rePassword)
        {
            $result[] = "El password no coincide.";
        }
        
        if (count($result) === 0) 
        {
            try
            {
                $userDTO = new userDTO(0, $nombreUsuario, $password);

                $userAppService = userAppService::GetSingleton();

                $createdUserDTO = $userAppService->create($userDTO);

                $_SESSION["login"] = true;
                    
                $_SESSION["nombre"] = $nombreUsuario;

                $result = 'index.php';

                $app = Aplicacion::getInstance();
                
                $mensaje = "Se ha registrado exitosamente, Bienvenido {$nombreUsuario}";
                
                $app->putAtributoPeticion('mensaje', $mensaje);
            }
            catch(userAlreadyExistException $e)
            {
                $result[] = $e->getMessage();
            }
        }

        return $result;
    }
}