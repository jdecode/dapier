<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <title>DAPIER</title>
</head>
<body>
<noscript>
    <strong>
        We're sorry but your browser doesn't support JavaScript. Please use an upgraded browser to continue.
    </strong>
</noscript>
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<div id="app">
    This is the root element "app".<br />
    If Vue would be running fine, you wouldn't be seeing this message!<br />
    Vue would use this element to load itself.
</div>
</body>
</html>

