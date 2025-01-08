<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';

    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    // Buscar usuario
    $sql = "SELECT id, contraseña FROM usuarios WHERE nombre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
    $stmt->execute();
    
    // Ejecutar la consulta y obtener resultados
    $stmt->bindColumn(1, $id);
    $stmt->bindColumn(2, $contraseñaHash);
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($id && password_verify($contraseña, $contraseñaHash)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['nombre'] = $nombre;
        header("Location: level1.php");
        exit;
    } else {
        $error = "Nombre o contraseña incorrectos.";
    }

    $stmt->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Suma</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>¡Bienvenido al Reto de Sumas!</h1>
    <p>¿Listo para poner a prueba tu mente? Conviértete en un maestro de las matemáticas. ¡Empieza ahora y conquista el juego!</p>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form method="POST">
            <?php if ($error): ?> 
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    </div>

    <!-- Icono para mutear/desmutear música -->
    <div class="sound-control">
        <img id="sound-icon" src="iconos/corneta-consonido.png" alt="Sonido Activado" />
    </div>

    <!-- Música de fondo -->
    <audio id="musica" loop>
        <source src="iconos/musica.mp3" type="audio/mp3">
    </audio>

    <script src="musica.js"></script>
</body>
<style>
    .login-container {
        position: absolute;
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        background: rgba(255, 255, 255, 0.9); 
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        width: 350px;
        text-align: center;
    }

    .login-container h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        background-color: #ff7043;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .login-container button:hover {
        background-color: #e64a19;
    }

    .login-container p {
        margin-top: 15px;
        font-size: 14px;
        color: #666;
    }

    .login-container a {
        color: #007BFF;
        text-decoration: none;
    }

    .login-container a:hover {
        text-decoration: underline;
    }
</style>
</html>
