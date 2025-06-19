<?php
include 'conexion.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recoger y limpiar datos
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. Validar datos básicos (no vacío y email válido)
    if (empty($email) || empty($password)) {
        die('Por favor, rellena todos los campos.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('El email no es válido.');
    }

    // 3. Comprobar que el email no esté registrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die('Este email ya está registrado.');
    }
    $stmt->close();

    // 4. Hashear la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insertar usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $passwordHash);

    if ($stmt->execute()) {
        echo 'Usuario registrado correctamente.';
        // Aquí podrías redirigir al login, por ejemplo
    } else {
        echo 'Error al registrar usuario: ' . $conn->error;
    }
    $stmt->close();

    $conn->close();
} else {
    echo 'Método no permitido.';
}
