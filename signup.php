<?php
//Con el metodo require se llama el archivo database.php
  require 'database.php';

  //validación del formulario
  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    if ($_POST['password'] !== $_POST['confirm_password']) {
      $message = 'Las contraseñas no coinciden';
    } else {
      // Continuar con la inserción en la base de datos
      $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':email', $_POST['email']);
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':password', $password);
  
      if ($stmt->execute()) {
        $message = 'USUARIO CREADO CON ÉXITO';
      } else {
        $message = 'ERROR DE CONEXIÓN';
      }
    }
  } else {
    $message = 'Por favor, completa todos los campos';
  }

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if(!empty($message)): ?>
  <p> <?= $message ?></p>
<?php endif; ?>

<h1>SignUp</h1>
    <span>or <a href="login.php">Login</a></span>

    <form action="signup.php" method="post">
<input type="text" name="email" placeholder="Ingresar correo">
<input type="password" name="password" placeholder="Ingresar contraseña">
<input type="password" name="confirm_password" placeholder="Confirmar tu contraseña">
<input type="submit" value="Send">

    </form>


</body>
</html>