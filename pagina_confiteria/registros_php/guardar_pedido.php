
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Lista de Clientes</h1>
    <?php
// Configura la conexión a la base de datos
session_start();

// Comprobar si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos (asegúrate de configurar tus propias credenciales)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "confiteria_bd";   

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar la conexión a la base de datos
    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
    }
}

// Recupera los datos del formulario
$id_pedidos = $_POST["id_pedidos"];
$id_sucursal = $_POST["id_sucursal"];
$id_cliente = $_POST["id_cliente"];
$metodo_de_pago = $_POST["metodo_de_pago"];
$fecha_de_pedido = $_POST["fecha_de_pedido"];
$estado_pedido = $_POST["estado_pedido"];
$id_producto = $_POST["id_producto"];

// Inserta los datos en la base de datos
$sql = "INSERT INTO pedidos (id_pedidos, id_sucursal, id_cliente, metodo_de_pago, fecha_de_pedido, estado_pedido, id_producto) 
VALUES ('$id_pedidos', '$id_sucursal', '$id_cliente', '$metodo_de_pago', '$fecha_de_pedido', '$estado_pedido', '$id_producto')";

if ($conn->query($sql) === TRUE) {
    echo "Pedidos agregados exitosamente.";
        // Consulta para listar todos los clientes
        $listarPedidosSQL = "SELECT * FROM pedidos";
        $result = $conn->query($listarPedidosSQL);
    
    // Después de insertar el cliente y mostrar el mensaje de éxito, puedes mostrar la lista en una tabla
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID Pedidos</th><th>Sucursal</th><th>ID Cliente</th><th>Método de Pago</th><th>Fecha de Pedido</th><th>Estado Pedido</th><th>ID Producto</th></tr>";


        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_pedidos"] . "</td>";
            echo "<td>" . $row["id_sucursal"] . "</td>";
            echo "<td>" . $row["id_cliente"] . "</td>";
            echo "<td>" . $row["metodo_de_pago"] . "</td>";
            echo "<td>" . $row["fecha_de_pedido"] . "</td>";
            echo "<td>" . $row["estado_pedido"] . "</td>";
            echo "<td>" . $row["id_producto"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No hay pedidos en la base de datos.";
    }
    echo '<form action="../formularios_html/index.html">
    <input type="submit" value="Continuar">
    </form>';
} else {
    echo "Error al agregar pedido: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
