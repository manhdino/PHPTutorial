<?php
if (!defined('_INCODE'))
    die('Access Deined...');
?>
<html>

<head>
    <title>User Manager</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/style.css?ver=<?php echo rand(); ?>" />
</head>

<body>
    <div class="container"
        style="display: flex; align-items: center; flex-direction: column; height: 100vh; justify-content: center">
        <h1 class="text-center">User Manager</h1>
        <p class="text-center"><a href="?module=users" class="btn btn-success btn-lg">Open</a></p>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATES; ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATES ?>/js/custom.js"></script>
</body>

</html>