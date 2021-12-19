<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>CRUD Compra</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/grid/">
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
    <link href="../CSS/Menu.css" rel="stylesheet">
  </head>
  <body class="py-4">
    
<main>
  <div class="container">

    <h1>Listado de todos los productos que tiene tu compra</h1>
    <p>Aquí vas a encontrar todos los productos de tu compra, solamente haz click en el siguiente botón para que se enlisten todos los productos.
    </p>
    <input type="submit" value="Listar compra" class="w-50 btn btn-secondary" id="listarCompra" name="listarCompra">
    

    <div class="row">
      <div class="col themed-grid-col"><b>Código</b></div>
      <div class="col themed-grid-col"><b>Nombre</b></div>
      <div class="col themed-grid-col"><b>Descripción</b></div>
      <div class="col themed-grid-col"><b>Precio</b></div>
    </div>

    <div class="row">
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
    </div>

    <div class="row">
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
    </div>

    <div class="row">
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
    </div>

    <div class="row">
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
    </div>

    <div class="row">
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
      <div class="col themed-grid-col"></div>
    </div>
   
  </div>

  <div id="boton">
      <a href="../Principal/Principal.php"><input type="button" value="Regresar a la página principal" class="w-50 btn btn-secondary"></a>
    </div>
</main>

</html>