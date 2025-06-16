<?php
include 'db.php'; 


$nombre = $_POST['nombre'];
$fecha_emision = $_POST['fecha_emision'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$importe = $_POST['importe'];
$pendiente_pago = $_POST['pendiente_pago'];


$sql = "INSERT INTO facturas (nombre, fecha_emision, fecha_vencimiento, importe, pendiente_pago)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdi", $nombre, $fecha_emision, $fecha_vencimiento, $importe, $pendiente_pago);

if ($stmt->execute()) {
    echo "Factura guardada correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
