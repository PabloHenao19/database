<?php
// Esto permite mantener y utilizar variables de sesión en el sitio web.
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
   
}

require 'database.php';

// Se verifica si se han enviado los campos de correo electrónico a través del formulario de inicio de sesión.
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    // La función password_verify verifica si una contraseña ingresada por el usuario coincide
    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        // Aquí se redirecciona al usuario
        header("Location: index.php");
        exit(); 
        
    } else {
        $message = 'Correo o Contraseña incorrectos';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">    
</head>
<body>
<?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

<h1>LOGIN</h1>
<span>or <a href="signup.php">SignUp</a></span>
    <form action="login.php" method="post">
<input type="text" name="email" placeholder="Ingresar correo">
<input type="password" name="password" placeholder="Ingresar contraseña">
<input type="submit" value="Send">
    </form>
    <a href="ForgotPassword.php">¿Olvidaste tu contraseña?</a>
</body>
</html>