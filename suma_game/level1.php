<?php
include 'functions.php';

$nivel = 1; 

$ejercicios = cargarEjercicios($nivel);

$todosCompletados = true;
foreach ($ejercicios as $ejercicio) {
    if (!esEjercicioCompletado($nivel, $ejercicio['id'])) {
        $todosCompletados = false;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio <?php echo $nivel; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Ejercicio</h1>
    <p>Selecciona un ejercicio para resolver:</p>
    
    <div class="exercise-list">
        <?php foreach ($ejercicios as $ejercicio): ?>
            <?php 
                $completado = esEjercicioCompletado($nivel, $ejercicio['id']);
            ?>
            <?php if ($completado): ?>
                <div>
                    <img src="iconos/completado.png" alt="Ejercicio completado" style="width: 220px; height: 220px;">
                </div>
            <?php else: ?>
                <a href="level1_exercise.php?ejercicio_id=<?php echo $ejercicio['id']; ?>">
                    <?php echo $ejercicio['id']; ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Botón para pasar al siguiente nivel si todos los ejercicios están completados -->
    <?php if ($todosCompletados): ?>
        <div>
            <form action="level2.php" method="GET">
                <button type="submit">Pasar al Nivel 2</button>
            </form>
        </div>
    <?php endif; ?>
    <div>
        <form action="index.php" method="GET">
            <button type="submit">Salir</button>
        </form>
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
</html>
