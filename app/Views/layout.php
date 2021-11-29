<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <?= $this->renderSection('style') ?>
    <title><?= $title ?? 'Course Computer Science' ?></title>
</head>

<body>
    <?= $this->include('navbar') ?>
    <?= $this->renderSection('content') ?>
</body>

<?= $this->renderSection('script') ?>
<script src="/js/bootstrap.bundle.min.js"></script>

</html>