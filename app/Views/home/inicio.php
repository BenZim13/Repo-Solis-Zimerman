<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

    <?= view('components/carrousel') ?>

    <?= view('components/cards') ?>

    <?= $this->endSection() ?>