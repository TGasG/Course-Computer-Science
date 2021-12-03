<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Aplikasi CRUD menggunakan Codeigniter 4 untuk tugas akhir mata kuliah Pemrograman Web">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, Codeigniter, Pemrograman Web, CRUD, MVC">
    <meta name="author" content="Kevin Leonard Sugiman">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <?= $this->renderSection('style') ?>
    <title><?= $title ?? 'Course Computer Science' ?></title>
</head>

<body>
<?= $this->include('navbar') ?>
<?= $this->renderSection('content') ?>
<?= $this->renderSection('script') ?>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>