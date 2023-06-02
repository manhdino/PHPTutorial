<?php
if (!defined('_INCODE')) die('Access denied...');

?>
<h2 style="text-align: left;color: red;">Error DB:</h2>
<p> <?php echo $e->getMessage(); ?></p>
<p> File: <?php echo $e->getFile(); ?></p>
<p> Line: <?php echo $e->getLine(); ?></p>