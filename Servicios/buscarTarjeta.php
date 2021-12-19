<?php
    
    $tarjeta = ($_POST["tarjeta"]);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "practica2";
    $data = array("respuesta"=> "No existe la tarjeta buscada");

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT nombre, apellido, tarjeta_credito FROM cliente WHERE tarjeta_credito='$tarjeta'";
    //echo $sql;

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            //echo "id: " . $row["id"]. " " . $row["correo"]. " " . $row["contrasena"]. " " . $row["rol"] . "<br>";
            $data = array("nombre"=>$row['nombre'], "apellidos"=>$row['apellido'], "tarjeta"=> $row['tarjeta_credito'], "tarjetaoriginal" => $tarjeta);
        }
    } else {
        //echo "0 results";
        http_response_code(404);
        die();
    }
    

    //$data = array("nombre"=>"gabriel;", "apellidos"=>"vidal",  "id" => 1, "tarjeta"=> $tarjeta);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);

?>