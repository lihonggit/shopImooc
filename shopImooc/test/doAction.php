<?php
require_once '../lib/string.func.php';
header("content-type:text/html;charset=utf8;");
/*
 * 关于上传：
 * 一、服务器端的php.ini中
 * 1.file_uploads = On 支持通过HTTP POST方式上传文件
 * 2.upload_tmp_dir 历史文件夹保存目录
 * 3.upload_max_filesize = 2M 默认2M，上传最大大小
 * 4.post_max_size = 8M，表单以POST方式发送数据的最大值
 * 二、客户端配置
 * <input type="hidden" name="MAX_FILE_SIZE" value="1024" />
 */
// $_FILES文件预保留变量
// var_dump($_FILES);
// print_r($_FILES); exit;
$file = @$_FILES['myFile'];
$filename = $file['name'];
$type = $file['type'];
$tmp_name = $file['tmp_name'];
$error = $file['error'];
$size = $file['size'];
$allowExt = array(
    "gif",
    "jpeg",
    "jpg",
    "png",
    "wbmp"
);
// 半M
$maxSize = 512000;
$imgFlag = true;
// 判断下错误信息
if ($error == UPLOAD_ERR_OK) {
    $ext = getExt($filename);
    // 限制上传文件类型
    if (! in_array($ext, $allowExt)) {
        exit("非法文件类型");
    }
    if ($size > $maxSize) {
        exit("文件过大");
    }
    if ($imgFlag) {
        // 如何验证一个文件是否是一个真正的图片类型?
        // getimagesize($filename);来判断是否是图片类型。
        $info=@getimagesize($tmp_name);
        if (!$info) {
            exit("不是真正的图片类型");
        }
    }
    $filename = getUniName() . "." . $ext;
    $path = "uploads";
    if (! file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $destination = $path . "/" . $filename;
    // 判断文件是否是通过HTTP POST上传上来的
    if (is_uploaded_file($tmp_name)) {
        if (move_uploaded_file($tmp_name, $destination)) {
            $mes = "文件上传成功";
        } else {
            $mes = "文件移动失败";
        }
    } else {
        $mes = "文件不是通过HTTP POST方式上传上来的";
    }
} else {
    switch ($error) {
        case UPLOAD_ERR_INI_SIZE:
            $mes = ".1超过了配置文件上传文件的大小";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $mes = ".2超过了表单设置上传文件的大小";
            break;
        case UPLOAD_ERR_PARTIAL:
            $mes = ".3部分文件被上传";
            break;
        case UPLOAD_ERR_NO_FILE:
            $mes = ".4没有文件被上传";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $mes = ".6没有找到临时目录";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $mes = ".7文件不可写";
            break;
        case UPLOAD_ERR_EXTENSION:
            $mes = ".8由于PHP的扩展程序中断了文件上传";
            break;
    }
}
echo $mes;