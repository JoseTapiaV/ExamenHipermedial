<?php
  session_start();
  $usuario_id=$_SESSION['Inicio'];
  $datos= null;
  $nombre="";
  $apellido="";
  $cedula="";
  $tarjeta="";
  $observacion= null;
  //var_dump($_POST);
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "practica2";
  $subtotal = 0;
  $iva = 0;
  $total = 0;
  date_default_timezone_set('America/Guayaquil');
  $HoraFecha=date("Y-m-d H:i:s");

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  //Capturar cedula, nombre y apellido del cliente para la factura 
  $sqlconsulta = "SELECT cedula, nombre, apellido, tarjeta_credito FROM cliente WHERE usuario_id='$usuario_id'";
  $result = mysqli_query($conn, $sqlconsulta);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $cedula=$row["cedula"];
      $nombre=$row["nombre"];
      $apellido=$row["apellido"];
      $tarjeta=$row["tarjeta_credito"];
      //echo "Nombre: " . $row["nombre"]."<br>";
    }
  } else {
    //echo "0 results";
  }

  //Muestra la tabla temporal de los productos seleccionados
  $sql = "SELECT * FROM detalle_temporal Where usuario=$usuario_id";
  $pedidoQuery = $conn->query($sql);
  $pedidoTempData=null;
  if ($pedidoQuery) {
    // output data of each row
    while($row = $pedidoQuery->fetch_assoc()) {
      //echo  $row["codigo"]. $row["nombre"]. " " . $row["descripcion"]. $row["precio"]."<br>";
      $pedidoTempData .= '<tr><td scope="col">'.$row["codigo"].'</td>'. '<td scope="col">'.$row["nombre"].'</td>'. '<td scope="col">'.$row["descripcion"].'</td>'. '<td scope="col">'.$row["precio"].'</td><td scope ="col"><input type=text value='.$row["cantidad"].' size="1"></td><td scope ="col">'.$row["producto"].'</td><td><input type="hidden" value="'.$row["codigo"].'" name="codigoProductoTemp"/></td></tr>';
      $subtotal = $subtotal+$row["precio"];
    }
  } else {
      //echo "0 results";
  }
  $iva = $subtotal * 0.12;
  $total = $subtotal + $iva;

  
  if($_POST){
    $producto=($_POST["nombreProducto"]);
    $observacion=($_POST["observaciones"]);
    //Mostrar todos los productos
    if(array_key_exists('listar', $_POST) && $_POST['listar']){

        $sql = "SELECT codigo, nombre, descripcion, precio FROM producto WHERE nombre LIKE '%$producto%'";
        //echo $sql;

        $result = $conn->query($sql);

        if ($result) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            //echo  $row["codigo"]. $row["nombre"]. " " . $row["descripcion"]. $row["precio"]."<br>";
            $datos .= '<tr><td scope="col">'.$row["codigo"].'</td>'. '<td scope="col">'.$row["nombre"].'</td>'. '<td scope="col">'.$row["descripcion"].'</td>'. '<td scope="col">'.$row["precio"].'</td><td><button type="submit" class="btn btn-dark" name="agregarPedido" value="'.$row["codigo"].'" >Agregar al pedido</button><input type="hidden" value="'.$row["codigo"].'" name="codigoProducto'.$row["codigo"].'"/></td></tr>';
          }
        } else {
            //echo "0 results";
        }
        
    }

    //Agregar a la tabla temporal
    if(array_key_exists('agregarPedido', $_POST) && $_POST['agregarPedido']){
      //echo $_POST['agregarPedido'];
      $consultaProducto = $_POST['agregarPedido'];
      $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
      $sqlcons = "SELECT codigo, nombre, descripcion, precio FROM producto where codigo=$consultaProducto";
      //echo $sqlcons;
      $result = $conn->query($sqlcons);

        if ($result) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          //echo "<br>";
          //echo  $row["codigo"]. $row["nombre"]. " " . $row["descripcion"]. $row["precio"]."<br>";
          $nombre=$row["nombre"];
          $descripcion=$row["descripcion"];
          $precio=$row["precio"];
          $codigo=$row["codigo"];
          
          $sql = "INSERT INTO detalle_temporal (nombre, descripcion, precio, producto, usuario)
            VALUES ( '$nombre', '$descripcion', $precio, $codigo, $usuario_id)";

            //echo $sql;

            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
        }
    }  

    //Confirmar la factura
    if(array_key_exists('guardarFactura', $_POST) && $_POST['guardarFactura']){

      //Insertar los datos a la factura cabecera
      $sql = "INSERT INTO factura_cabecera (nombre, apellido, hora_fecha, subtotal, iva, total, observaciones, cedula_id)
      VALUES ('$nombre', '$apellido', '$HoraFecha', $subtotal, $iva, $total, '$observacion', '$cedula')";
      
      if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        $last_id = $conn->insert_id;
        //Insertar los datos a la factura detalle
        $sql = "SELECT * FROM detalle_temporal Where usuario=$usuario_id";
        $pedidoQuery = $conn->query($sql);
        $pedidoTempData=null;
        if ($pedidoQuery) {
          // output data of each row
          while($row = $pedidoQuery->fetch_assoc()) {
            //echo  $row["codigo"]. $row["nombre"]. " " . $row["descripcion"]. $row["precio"]."<br>";
              $nombre=$row["nombre"];
              $precio=$row["precio"];        
              $cantidad=$row["cantidad"];
              $codigo=$row["producto"];
              $sql = "INSERT INTO factura_detalle (nombre, precio, cantidad, cod_producto, cod_cabecera)
              VALUES ('$nombre', $precio, $cantidad, $codigo, $last_id)";

              if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
          }
        } else {
            //echo "0 results";
        }
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      
    }
  }
  
  $conn->close();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Listar Menú</title>

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
                <p>A continuación puedes escribir el nombre del producto que deseas agregar a tu pedido.</p>
                <input type="text" class="form-control" id="nombreProducto" size="20" name="nombreProducto" placeholder="Tu producto deseado"><br> 
                <input type="submit" value="Listar Productos" class="w-50 btn btn-secondary" id="listar" name="listar">
                <p><br>A continuación, se mostrará el menú completo con todos sus detalles.</p>

                <form method="post" action="">
                  <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Opcion</th>
                        </tr>  
                        <?php 
                            echo $datos;
                        ?>
                    </thead>
                  </table>
                </form>

                <h1><br>¿Viste algo que te gustó? A continación puedes comprarlo.</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Producto</th>
                        </tr>  
                        <?php 
                            echo $pedidoTempData;
                        ?>
                    </thead>
                </table>
                <br>
                <table id="tabla">
                  <tr>
                    <td> 
                      <p>Observaciones:&nbsp;</p> 
                    </td>
                    <td> 
                      <input type="text" class="form-control" id="observaciones" size="40" name="observaciones" placeholder="Aquí puedes escribir tu observación"> 
                    </td>
                  </tr>
                  <tr>
                    <td> 
                      <p>Subtotal:&nbsp;</p> 
                    </td>
                    <td> 
                      <input type="number_format(double)" class="form-control" id="subtotal" size="5" name="subtotal" value=<?php echo $subtotal ?>> 
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <p>IVA:&nbsp;</p>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="iva"  size="5" name="iva" value=<?php echo $iva ?>>
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <p>Total:&nbsp;</p>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="total"  size="5" name="total" value=<?php echo $total ?>>
                    </td>
                  </tr>
                </table>
                <br>
                <br><input type="submit" value="Guardar Factura" class="w-50 btn btn-secondary" id="Guardar" name="guardarFactura">
                <br>
                <br><a href="../Principal/Principal.php"><input type="button" value="Regresar a la página principal" class="w-50 btn btn-secondary"></a>
                <br><br>
            </div>  
        </main>
    </form>
</body>

</html>
