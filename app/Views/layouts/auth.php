<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Iniciar Sesión' ?></title>
  <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro">
  <style>
    body {
      background-color: #f4f6f9;
    }
    .login-box {
      max-width: 400px;
      margin: 80px auto;
    }
  </style>
</head>
<body class="hold-transition">
  <div class="login-box">
    <?= $this->renderSection('content') ?>
  </div>
</body>
</html>
