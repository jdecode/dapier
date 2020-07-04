<?php
use Cake\Routing\Router;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/favicon.ico">
    <title>DAPIER</title>
    <link rel="stylesheet" href="<?= Router::url('/') ?>fonts/fontawesome-all.min.css" />
    <link rel="stylesheet" href="<?= Router::url('/') ?>fonts/font-awesome.min.css" />
    <link rel="stylesheet" href="<?= Router::url('/') ?>css/style-tw.css" />
</head>
<body>
    <noscript>
        <strong>
            !JS
        </strong>
    </noscript>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <div id="app">
        !V
    </div>
    <script type="text/javascript" defer src="<?= Router::url('/') ?>vue/js/chunk-vendors.js"></script>
    <script type="text/javascript" defer src="<?= Router::url('/') ?>vue/js/app.js"></script>
</body>
</html>

