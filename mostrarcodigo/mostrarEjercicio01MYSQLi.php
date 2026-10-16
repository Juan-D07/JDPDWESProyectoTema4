<?php
echo "PHP version: " . PHP_VERSION . "<br>";

echo "Display errors: ";
var_dump(ini_get("display_errors"));

echo "Error reporting level: ";
var_dump(error_reporting());
?>