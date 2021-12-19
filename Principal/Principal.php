<?php
      session_start();
      $id = $_SESSION['Inicio'];
      //echo $id;
      $rol="";
      $nombre="";
      $nombreRe="";

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

      $sql = "SELECT rol FROM usuario WHERE id='$id'";
      //echo $sql;

      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $usuarioEncontrado = TRUE;
          //echo "id: " . $row["id"]. " " . $row["correo"]. " " . $row["contrasena"]. " " . $row["rol"] . "<br>";
          $rol = $row["rol"];
        }
      } else {
        //echo "0 results";
      }

      //Sacar nombre del cliente
      $sqlconsulta = "SELECT nombre FROM cliente WHERE usuario_id='$id'";
      $result = mysqli_query($conn, $sqlconsulta);

      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $nombre=$row["nombre"];
          //echo "Nombre: " . $row["nombre"]."<br>";
        }
      } else {
        //echo "0 results";
      }

      //Sacar nombre del restaurante
      $sqlconsultaRE = "SELECT nombre FROM restaurante WHERE usuario_id='$id'";
      $result = mysqli_query($conn, $sqlconsultaRE);

      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $nombre=$row["nombre"];
          //echo "Nombre: " . $row["nombre"]."<br>";
        }
      } else {
        //echo "0 results";
      }

      mysqli_close($conn);
      //echo $rol;
    
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Practica 02</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/product/">

    

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="../CSS/product.css" rel="stylesheet">
  </head>
  <body>
<!-- Botones superiores -->
<header class="site-header sticky-top py-1">
  <nav class="container d-flex flex-column flex-md-row justify-content-between">
    <a class="py-2" href="#" aria-label="Product">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mx-auto" role="img" viewBox="0 0 24 24"><title>Product</title><circle cx="12" cy="12" r="10"/><path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>
    </a>
    <a class="py-2 d-none d-md-inline-block" href="#"></a>
    <a class="py-2 d-none d-md-inline-block" href="#"></a>
    <a class="py-2 d-none d-md-inline-block" href="#"></a>
    <a class="py-2 d-none d-md-inline-block" href="#"></a>
    <a class="py-2 d-none d-md-inline-block" href="#"></a>
    <?php echo '<a class="py-2 d-none d-md-inline-block" href="">'.$nombre.'</a>' ?>
    <a class="py-2 d-none d-md-inline-block" href="../index.php">Cerrar Sesión</a>
  </nav>
</header>

<main>
  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light" style="background-image: url('../Images/comidaPrincipal.jpg'); width: 100%; height: 100vh; ">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: #FFFFFF" >
      <h1 class="display-4 fw-normal">Tu catálogo de restaurantes</h1>
      <p class="lead fw-normal">En esta página se te mostrará un catálogo. de varios productos que pueden ofreceer los restaurantes.</p>
  </div>

  <?php if($rol == 'C'):?>
  <!-- Botón para mostrar el menú completo-->
  <div class=" text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <p>¿No encuentras todo loque buscas? No te preocupes, puedes seguir buscándolo desde nuestra sección de búsqueda. Incluso, si te gusta algo del menú, puedes comprarlo.</p>
      <a class="btn btn-outline-secondary" href="../MenuCompra/MenuCompra.php" id="Compras">Búsqueda y Compra</a>
    </div>
  </div>
  <?php elseif($rol == 'R'):?>
    <!-- Botón para el CRUD de los productos-->
    <div class=" text-center bg-light">
      <div class="col-md-5 p-lg-5 mx-auto my-5">
        <p >¿Quieres actualizar o manipular tus productos? En el siguiente botón lo encontrarás.</p>
        <a class="btn btn-outline-secondary" href="../CRUDProducto/CrearActualizarEliminar.php">Actualizar productos</a>
        <br><br><p>A continuación escribe el número de la tarjeta opara buscarla</p>
        <input type="text" class="form-control" id="tarjetaCredito" placeholder="Ingresa el número de la tarjeta" size="40" name="tarjetaCredito"><br>
        <a class="btn btn-outline-secondary" id="buscarTarjeta">Buscar tarjeta </a>
          <div id="resultado">
          </div>
      </div>
    </div>
  <?php endif ?>

  <!-- Scripts -->
  <!-- <script src="assets/dist/js/bootstrap.bundle.min.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="../js/Principal.js"></script>
  </body>
</html>
