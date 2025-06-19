<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
include 'conexion.php';  

$respuesta = ['ok' => false, 'mensaje' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $respuesta['mensaje'] = 'Por favor, rellena todos los campos.';
        echo json_encode($respuesta);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $respuesta['mensaje'] = 'El email no es válido.';
        echo json_encode($respuesta);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    if (!$stmt) {
        $respuesta['mensaje'] = 'Error al preparar la consulta.';
        echo json_encode($respuesta);
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $respuesta['mensaje'] = 'Este email ya está registrado, te llevamos a login.';
        $respuesta['redirectUrl'] = '/frontend/register.html';
        echo json_encode($respuesta);
        exit;
    }
    $stmt->close();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
    if (!$stmt) {
        $respuesta['mensaje'] = 'Error al preparar el insert.';
        echo json_encode($respuesta);
        exit;
    }

    $stmt->bind_param("ss", $email, $passwordHash);
    if ($stmt->execute()) {
        $respuesta['ok'] = true;
        $respuesta['mensaje'] = 'Usuario registrado correctamente.';
        $respuesta['redirectUrl'] = '/frontend/register.html';
    } else {
        $respuesta['mensaje'] = 'Error al registrar usuario: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $respuesta['mensaje'] = 'Método no permitido.';
}

echo json_encode($respuesta);
