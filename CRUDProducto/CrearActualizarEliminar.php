<?php
    session_start();
    $usuario_id=$_SESSION['Inicio'];
    $codigoRestaurante="";
    if($_POST){
        if($_POST['registrar']){
            //Para ingresar un producto nuevo
            $codigo = ($_POST["codigo"]);
            $nombre = ($_POST["nombre"]);
            $descripcion = ($_POST["descripcion"]);
            $precio = ($_POST["precio"]);
    
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

            $sql = "INSERT INTO producto (nombre, descripcion, precio, restaurante_id)
            VALUES ( '$nombre', '$descripcion', '$precio', $codigoRestaurante)";

            //echo $sql;

            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

        }elseif($_POST['actualizar']){
            //para actualizar un producto
            $codigo = ($_POST["codigo"]);
            $nombre = ($_POST["nombre"]);
            $descripcion = ($_POST["descripcion"]);
            $precio = ($_POST["precio"]);

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

            $sql = "UPDATE producto SET nombre='$nombre', descripcion='$descripcion', precio='$precio' WHERE codigo=$codigo";

            if ($conn->query($sql) === TRUE) {
              //echo "Record updated successfully";
            } else {
              //echo "Error updating record: " . $conn->error;
            }

            $conn->close();
        }elseif($_POST['eliminar']){
            //Para eliminar el producto            
            $codigo = ($_POST["codigo"]);
            $nombre = ($_POST["nombre"]);
            $descripcion = ($_POST["descripcion"]);
            $precio = ($_POST["precio"]);

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

            // sql to delete a record
            $sql = "DELETE FROM producto WHERE codigo=$codigo";

            if ($conn->query($sql) === TRUE) {
              //echo "Record deleted successfully";
            } else {
              //echo "Error deleting record: " . $conn->error;
            }

            $conn->close();
        }
    }   
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear producto</title>
    <link rel="stylesheet" href="../CSS/Registro.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="center">
  <form method="post" action="">
  <main>

    <div id="columna1">
        <h1>Registro para nuevos productos del menú.</h1>

        <p>A continuación ingrese los siguientes datos del producto:</p><br>
        <table id="tabla">
          <tr>
            <td> 
              <p>Código:&nbsp;</p> 
            </td>
            <td> 
              <input type="number_format(int)" class="form-control" id="codigo" placeholder="Útil solo para actualizar o eliminar" size="40" name="codigo"> 
            </td>
          </tr>
          <tr>
            <td> 
              <p>Nombre:&nbsp;</p> 
            </td>
            <td> 
              <input type="text" class="form-control" id="nombres" placeholder="Su platillo" size="40" name="nombre"> 
            </td>
          </tr>
          <tr>
            <td>
              <p>Descripción:&nbsp;</p>
            </td>
            <td>
              <input type="text" class="form-control" id="descripcion" placeholder="Descripcion del platillo" size="40" name="descripcion">
            </td>
          </tr>
          <tr>
            <td>
              <p>Precio:&nbsp;</p>
            </td>
            <td>
              <input type="number_format(doubleval)" class="form-control" id="precio" placeholder="1.50" size="40" name="precio">
            </td>
          </tr>
        </table>
        <br>
        <br><input type="submit" value="Registrar Producto" class="w-50 btn btn-secondary" id="registrar" name="registrar">
        <br>
        <br><input type="submit" value="Actualizar Producto" class="w-50 btn btn-secondary" id="actualizar" name="actualizar">
        <br>
        <br><input type="submit" value="Eliminar Producto" class="w-50 btn btn-secondary" id="eliminar" name="eliminar">
        <br>
        <br><a href="Listar.php"><input type="button" value="Listar todos los productos" class="w-50 btn btn-secondary"></a>
        <br>
        <br><a href="../Principal/Principal.php"><input type="button" value="Regresar" class="w-50 btn btn-secondary"></a>
    </div>
  </form>

  </main>
        
</body>

</html>