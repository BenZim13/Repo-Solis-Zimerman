<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $titulo ?? 'SuperCarpi' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('public/assets/css/miestilo.css') ?>">
</head>

<body class="d-flex flex-column min-vh-100 pt-5">

    <?= view('components/cabecera') ?>

    <main class="flex-grow-1">
        <div class="container mt-4">
            <?= $this->renderSection('content_for_layout') ?>

            <?php /*
            <?= $ini ?? '' ?>
            <?= $car ?? '' ?>
            <?= $card ?? '' ?>
            <?= $who ?? '' ?>
            <?= $comerc ?? '' ?>
            <?= $contact ?? ''?>
            <?= $term ?? ''?>
            */ ?>
        </div>
    </main>

    <?= view('components/footer') ?>

    <script src="<?= base_url('public/js/main.js') ?>"></script> </body>
</html>