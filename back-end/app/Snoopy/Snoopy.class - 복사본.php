<?php

include_once 'Snoopy.class.php';
$snoopy = new snoopy;
$snoopy->fetch("http://www.naver.com");
$txt = $snoopy->results;
print_r($txt);

?>
