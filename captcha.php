<?php

session_start();


$number1 = rand(1,10);
$number2 = rand(1,10);


$_SESSION['simpleform_number_1'] = $number1;
$_SESSION['simpleform_number_2'] = $number2;


echo "{ \"number1\": \"".$number1."\", \"number2\": \"".$number2."\" }";