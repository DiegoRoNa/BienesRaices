<?php 

require 'includes/config/database.php';
$db = conectarDB();

$errores = [];

//AUTENTICAR AL USUARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //VALIDAR EL EMAIL Y CONTRASEÑA
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = 'Ingresa un correo';
    }
    if (!$password) {
        $errores[] = 'Ingresa tu contraseña';
    }


    //COMPROBAR QUE EXISTA EL USUARIO
    if (empty($errores)) {
        $query = "SELECT * FROM usuarios WHERE email = '${email}';";
        $resultado = mysqli_query($db, $query);
        
        //COMPROBAR QUE DEVUELVE UN USUARIO
        if ($resultado->num_rows) {
            //REVISAR SI EL PASSWORD ES CORRECTO
            $usuario = mysqli_fetch_assoc($resultado);//info del usuario
            
            //verificar contraseña
            $auth = password_verify($password, $usuario['password']);

            //CREAR LA SESION DEL USUARIO
            if ($auth) {
                session_start();

                //LLENAR LA SESION
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                
                header('Location: /admin');
            }else{
                $errores[] = 'Tu contraseña es incorrecta';
            }

        }else{
            $errores[] = 'El usuario no existe';
        }
    }
}

require 'includes/funciones.php';
incluirTemplate('header');

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar sesión</h1>

        <!--MOSTRAR ERRORES DE INPUT VACIOS-->
        <?php foreach($errores as $error): ?>
            <div class="alerta error"><?=$error;?></div>
        <?php endforeach; ?>
        
        <form class="formulario" method="POST">
            <fieldset>
                <legend>Correo y contraseña</legend>

                <label for="email">Correo:</label>
                <input type="email" id="email" name="email" placeholder="Tu correo">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña">
            </fieldset>

            <input type="submit" value="Ingregsar" class="boton boton-verde">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>