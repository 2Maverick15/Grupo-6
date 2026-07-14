<?php
session_start(); // Inicializar la sesion de forma segura.

// Configuracion de seguridad de la cookie de sesion
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Activar si usas HTTPS
ini_set('session.use_only_cookies', 1);

// Re-validacion rapida de entrada (Capa 2) 
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$email || empty($password)) {
    die("Credenciales invalidas.");
}

// [Paso del Estudiante 2]: Conexion PDO y Sentencia Preparada para buscar al usuario
try {
    // $db es la instancia PDO provista por el [Estudiante 2]
    $stmt = $db->prepare("SELECT id, username, password_hash FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        // Autenticacion exitosa: Regenerar ID de sesion para evitar fijacion de sesiones
        session_regenerate_id(true);
        
        // Gestionar variables de sesion 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['last_activity'] = time();

        header("Location: dashboard.php");
        exit();
    } else {
        // Mensaje generico para no dar pistas a atacantes
        die("Email o contraseña incorrectos.");
    }

} catch (PDOException $e) {
    // Registro interno del error (¡Sin fugas de informacion en el catch!) 
    error_log($e->getMessage());
    die("Ocurrio un error en el servidor. Por favor, intente mas tarde.");
}