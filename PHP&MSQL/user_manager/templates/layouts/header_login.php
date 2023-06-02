<?php
if (!defined('_INCODE')) die('Access denied...');
//echo '<br />';
//echo 'templates/layouts/header_login';
?>

<html>

<head>
    <title><?php echo $data['pageTitle'] ?? 'Dinomanh' ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/style.css?ver=<?php echo rand(); ?>" />
</head>

<body>