<?php
$text = $_POST['text'];
$output = wordwrap($text, 10, "<br>");
echo $output;
?>