<?php
  session_start();
  $usuarioEncontrado = FALSE;
  if($_POST){
    if($_POST['inicioSesion']){
      $correo = ($_POST['correo']);
      $contrasena = ($_POST['contrasena']);

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "practica2";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT id, correo, contrasena, rol FROM usuario WHERE correo='$correo' AND contrasena='$contrasena'";
      //echo $sql;

      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $usuarioEncontrado = TRUE;
          //echo "id: " . $row["id"]. " " . $row["correo"]. " " . $row["contrasena"]. " " . $row["rol"] . "<br>";
          $sqlconsulta = "SELECT nombre FROM cliente WHERE usuario_id=' $row[id] '";
          $_SESSION['Inicio'] = $row["id"];
        }
      } else {
        //echo "0 results";
      }
      mysqli_close($conn);
      //echo $_SESSION['Inicio'];
    }
  }
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Inicio de sesión</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">
    <br>
    <br>
  </head>
  
  <style>
    
    body {
      display: flex;
      justify-content: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
      text-align: center;
    }
  </style>

<body >
<main >
  <form method="post" action="">
    <img class="mb-4" src="Images/InicioSesion.png" alt="" width="300" height="200">
    <h1 >Por favor inicia sesión</h1>
    <?php 
            if ($usuarioEncontrado){
                echo '<div class="alert alert-dark" role="alert">
                Usuario:' . $correo . '<br>Inició sesión correctamente!
                </div>';
                header("Location: Principal/Principal.php");
            }
            if($_POST && !$usuarioEncontrado){
                echo '<div class="alert alert-dark" role="alert">
                No inició sesión correctamente! Intente ingresar nuevamente con los datos correctos!<br>Si no tiene una cuenta puede crear una nueva.
                </div>';
            }
    ?>


    <div class="form-floating" width="200" >
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" size="50" name="correo"> 
      <label for="floatingInput">Correo electrónico</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="contrasena"> 
      <label for="floatingPassword">Contraseña</label>
    </div>
    <br>
    <a href="Principal/Principal.php"><input type="submit" value="Iniciar Sesión" class="w-100 btn btn-secondary" id="inicioSesion" name="inicioSesion"></a>
    <p></p>
    <a href="Registrarse/Registro.php"><input type="button" value="Registrarse" class="w-100 btn btn-secondary"></a>
  </form>
</main>

</body>
    

</html>