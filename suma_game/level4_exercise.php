<?php
session_start();
include 'functions.php';

$ejercicio_id = $_GET['ejercicio_id'] ?? null;
if (!$ejercicio_id || !is_numeric($ejercicio_id)) {
    die("Error: ID del ejercicio no válido.");
}

$ejercicio = obtenerEjercicioPorId($ejercicio_id);

if (!$ejercicio) {
    die("Error: No se encontró el ejercicio con ID $ejercicio_id.");
}

$sumando1 = $ejercicio['sumando1'];
$sumando2 = $ejercicio['sumando2'];
$respuestaCorrecta = $ejercicio['respuesta'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuestaUsuario = $_POST['respuesta'] ?? '';

    if ($respuestaUsuario === (string)$respuestaCorrecta) {
        marcarEjercicioCompletado(4, $ejercicio_id);
        header("Location: level4.php?respuesta=correcta");
        exit();
    } else {
        $error = "Respuesta incorrecta. Inténtalo de nuevo.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio <?php echo htmlspecialchars($ejercicio_id); ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 5em;
            color: #333;
        }
        .line {
            display: block;
            border-top: 2px solid black; 
            width: 20%; /
            margin: 20px auto 0; 
        }

        .sum-container {
            display: grid; 
            grid-template-columns: 1fr; 
            grid-template-rows: auto auto auto; 
            justify-items: center; 
            margin: 20px auto;
            font-size: 5em;
            text-align: right;
        }

        .sum-container .number {
            margin: 0; 
        }

        .sum-container .line {
            border-top: 4px solid black;
            margin: 5px 0;
        }

        .answer-box {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px dashed black;
            width: 70px;
            height: 70px;
            font-size: 1.5em; 
            text-align: center;
            line-height: 1; 
        }
        .answer-box-container {
            display: flex;
            justify-content: center; 
            margin-top: 10px; 
            gap: 15px; 
        }
        .number-buttons {
            margin: 20px;
        }
        .number-buttons .draggable {
            background-color: #ff7043;
            color: white;
            font-size: 3em;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: grab;
            display: inline-block;
            border-radius: 5px;
        }

        .number-buttons .draggable:hover {
            background-color: #db6e43;
        }

        .validate-btn {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            font-size: 1.5em;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .validate-btn:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-weight: bold;
            font-size: 0.5em;
        }

        a {
            display: block;
            margin-top: 20px;
            font-size: 1.2em;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Ejercicio </h1>
    <div class="sum-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <div class="number"><?php echo  $sumando1; ?></div>
        <div class="number"><?php echo  $sumando2; ?></div>
        <div class="line"></div>
        <form method="POST" action="level4_exercise.php?ejercicio_id=<?php echo $ejercicio_id; ?>">
            <input type="hidden" name="respuesta" id="respuestaInput" value="">
            <div class="answer-box-container">
                <?php for ($i = 0; $i < strlen($respuestaCorrecta); $i++): ?>
                    <div 
                        class="answer-box" 
                        id="respuestaBox-<?php echo $i; ?>" 
                        ondrop="soltarNumero(event, <?php echo $i; ?>)" 
                        ondragover="permitirSoltar(event)"
                        data-posicion="<?php echo $i; ?>">
                    </div>
                <?php endfor; ?>
            </div>
            <button type="submit">Validar Respuesta</button>
        </form>
    </div>
    <div class="number-buttons">
        <?php for ($i = 0; $i <= 9; $i++): ?>
            <div 
                class="draggable" 
                draggable="true" 
                ondragstart="arrastrarNumero(event)" 
                data-numero="<?php echo $i; ?>">
                <?php echo $i; ?>
            </div>
        <?php endfor; ?>
    </div>

    <a href="level4.php">Volver a la selección de ejercicios</a>

    <!-- Icono para mutear/desmutear música -->
    <div class="sound-control">
        <img id="sound-icon" src="iconos/corneta-consonido.png" alt="Sonido Activado" />
    </div>

    <!-- Música de fondo -->
    <audio id="musica" loop>
        <source src="iconos/musica.mp3" type="audio/mp3">
    </audio>

    <script src="musica.js"></script>

    <script>
        let respuestaArray = new Array(<?php echo strlen($respuestaCorrecta); ?>).fill(''); 

        function permitirSoltar(event) {
            event.preventDefault();
        }

        function arrastrarNumero(event) {
            const numero = event.target.getAttribute('data-numero');
            event.dataTransfer.setData("text", numero);
        }

        function soltarNumero(event, posicion) {
            event.preventDefault();

            const numero = event.dataTransfer.getData("text");

            respuestaArray[posicion] = numero;

            document.getElementById(`respuestaBox-${posicion}`).textContent = numero;

            document.getElementById('respuestaInput').value = respuestaArray.join('');
        }
    </script>
</body>
</html>