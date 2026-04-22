<?php 

$user = "Andrei";

$template = file_get_contents("index.tpl");
$html = str_replace("{user}", $user, $template );
echo $html;
