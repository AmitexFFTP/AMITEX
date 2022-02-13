<?php
if(!array_key_exists('page', $_GET)) { include("inc_accueil.php"); }
if(array_key_exists('page', $_GET) && $_GET['page'] == 'dlamitex') { include("dlamitex.php"); };

?> 
