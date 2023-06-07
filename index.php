<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME TO YOUR APP</title>

    <link rel="stylesheet" href="style.css">
    
</head>

<body>
<?php if(!empty($user)): ?>
    <!-- User es la base de dato con el punto en bienvenido se concatena el dato almacenado en email-->
      <br> BIENVENIDO. <?= $user['email']; ?>
      <br>HAS INGRESADO CORRECTAMENTE
      <!-- en href debo ingresar la dirreción a la cual me llevara el servidor  -->
      <a href="logout.php"> Logout </a>
    <?php else: ?>

<h1>Plase Login or signUp</h1>
<a href="login.php">Login</a> or
<a href="signup.php">SignUp</a>
<?php endif; ?>

    
</body>
</html>