<?php
require_once '../lib/string.func.php';
require_once 'upload.func.php';
header("content-type:text/html;charset=utf8;");

$fileInfo = $_FILES["myFile"];
$info = uploadFile($fileInfo);
echo $info;