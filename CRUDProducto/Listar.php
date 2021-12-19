<?php
    session_start();
    $usuario_id=$_SESSION['Inicio'];
    $codigoRestaurante="";
    $datos= null;

    if($_POST){
    if($_POST['listar']){

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

        $sqlcod = "SELECT codigo FROM restaurante WHERE usuario_id='$usuario_id'";
        //echo $sql;

        $result = mysqli_query($conn, $sqlcod);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "id: " . $row["id"]. " " . $row["correo"]. " " . $row["contrasena"]. " " . $row["rol"] . "<br>";
                $codigoRestaurante = $row["codigo"];
            }
        } else {
              //echo "0 results";
        }

        $sql = "SELECT codigo, nombre, descripcion, precio FROM producto WHERE restaurante_id = $codigoRestaurante";
        //echo $sql;

        $result = $conn->query($sql);

        if ($result) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            //echo  $row["codigo"]." ". $row["nombre"]. " " . $row["descripcion"]." ".$row["precio"]."<br>";
            $datos .= '<tr><td scope="col">'.$row["codigo"].'</td>'. '<td scope="col">'.$row["nombre"].'</td>'. '<td scope="col">'.$row["descripcion"].'</td>'. '<td scope="col">'.$row["precio"].'</td></tr>';
        }
        } else {
            echo "0 results";
        }
        $conn->close();
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
    <title>Listar Producto</title>

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
    <link href="../CSS/Listar.css" rel="stylesheet">
  </head>
<body class="center">
    <form method="post" action="">
            
        <main>
            <div id="columna1">

                <h1>Listado de todos los productos</h1>
                <p>Aquí puedes encontrar el menú completo del restaurante.</p>
                <input type="submit" value="Listar Productos" class="w-50 btn btn-secondary" id="listar" name="listar">
                <p><br>A continuación, se mostrará el menú completo con todos sus detalles.</p>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                        </tr>  
                        <?php 
                            echo $datos;
                        ?>
                    </thead>
                </table>
                <br><br>
                <br><br>
                <br><a href="../Principal/Principal.php"><input type="button" value="Regresar a la página principal" class="w-50 btn btn-secondary"></a>

            </div>  
        </main>
    </form>
</body>

</html>
