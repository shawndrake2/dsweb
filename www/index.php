<?php
// Main config
require_once 'config.php';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=SITE_NAME;?></title>
<?php $Site->head(); ?>
</head><body>
<header><?php $Site->get('header'); ?></header>

<!-- TESTING -->
<div style="margin:20px 0;">
    <input type="button" value="Load character" onclick="test.editCharacter()" />
</div>
<!-- TESTING -->

<div class="container">
    <nav><?php $Site->get('nav'); ?></nav>
    <section id="ajax"></section>
</div>
<footer><?php $Site->get('footer'); ?></footer>
</body></html>