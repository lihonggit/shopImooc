<?php
require_once '../lib/string.func.php';
require_once 'upload.func.php';
header("content-type:text/html;charset=utf8;");
foreach ($_FILES as $val) {
    $info = uploadFile($val);
    echo $info;
}
