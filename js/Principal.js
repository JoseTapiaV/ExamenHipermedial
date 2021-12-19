  $(document).ready(function(){
    $("#buscarTarjeta").click(function(){
        var tarj = $("#tarjetaCredito").val();
        console.log("Buscando tarjeta");
        $.ajax({
            url: "http://localhost/Practica02/Servicios/buscarTarjeta.php" , 
            type: "POST",
            data: {
                tarjeta : tarj
            },
        })
        .done(function( data ) {
            $("#resultado").html(`
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>  
                        <tr>
                            <td scope="col">${data.nombre}</td>
                            <td scope="col">${data.apellidos}</td>
                        </tr>
                    </thead>
                </table>
            `);
            console.log(data);
        })
        .fail(function( data ) {
            $("#resultado").html(`<div class="alert alert-danger mt-3">Tarjeta no encontrada</div>`);
            console.log(data);
        });;
    });
  });