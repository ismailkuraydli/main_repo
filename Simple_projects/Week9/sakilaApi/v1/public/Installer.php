<?php

require_once __DIR__.'/../framework/core/Framework.class.php';

Framework::classLoad();
Loader::helper("Install");
$install = new Install;
?>
