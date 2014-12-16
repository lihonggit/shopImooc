<?php
// var_dump($_FILES);
// require_once '../lib/string.func.php';
// require_once 'upload.func.php';
// header("content-type:text/html;charset=utf8;");
// foreach ($_FILES as $val) {
//     $info = uploadFile($val);
//     echo $info;
// }
/**
 * 构建上传文件信息
 * @return array
 */
function buildInfo() {
    $i = 0;
    foreach ($_FILES as $v ) {
        /* 单文件 */
        if (is_string($v['name'])) {
            $files[$i] = $v;
            $i++;
        } else {
            /* 多文件 */
            foreach ($v['name'] as $key => $val) {
                $files[$i]['name'] = $val;
                $files[$i]['size'] = $v['size'][$key];
                $files[$i]['tmp_name'] = $v['tmp_name'][$key];
                $files[$i]['error'] = $v['error'][$key];
                $files[$i]['type'] = $v['type'][$key];
                $i++;
            }
        }
    }
    return $files;
}




