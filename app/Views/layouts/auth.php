<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title><?= $title ?? 'Iniciar Sesión' ?></title>
  <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    html, body {
      height: 100%;
      width: 100%;
      overflow-x: hidden;
    }
    body {
      background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
      min-height: 100vh;
    }
    .login-box {
      width: 100%;
      max-width: 100%;
      min-height: 100vh;
      display: flex;
      
      align-items: flex-start;
      justify-content: center;
      padding: 60px 15px 15px;

    }
    @media (min-width: 576px) {
      .login-box {
        max-width: 450px;
        margin: 50px auto;
        min-height: auto;
        padding: 3px 20px;
      }
    }
  </style>
</head>
<body class="hold-transition">
  <div class="login-box">
    <?= $this->renderSection('content') ?>
  </div>
</body>
</html>
