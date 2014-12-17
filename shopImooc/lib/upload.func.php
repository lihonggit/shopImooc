<?php
require_once '../lib/string.func.php';
header("content-type:text/html;charset=utf8;");

/**
 * 单个文件上传
 * @param unknown $fileInfo
 * @param unknown $allowExt
 * @param number $maxSize
 * @param string $imgFlag
 * @param string $path
 * @return string
 */
function uploadFile($fileInfo, $allowExt = array("gif","jpeg","jpg","png","wbmp"), $maxSize = 512000, $imgFlag = true,$path = "uploads")
{
    // $type = $fileInfo['type'];
    $filename = $fileInfo['name'];
    $tmp_name = $fileInfo['tmp_name'];
    $error = $fileInfo['error'];
    $size = $fileInfo['size'];
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
            $info = @getimagesize($tmp_name);
            if (! $info) {
                exit("不是真正的图片类型");
            }
        }
        $filename = getUniName() . "." . $ext;
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
    return $mes;
}


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

/**
 * 多文件上传
 *
 */
function uploadFiles($allowExt = array("gif","jpeg","jpg","png","wbmp"), $maxSize = 2097152, $imgFlag = true,$path = "uploads") {
    // 检查文件夹
    if (!file_exists($path)) {
        mkdir($path,0777,true);
    }
    $i=0;
    $files=@buildInfo();
    if (!isset($files)) {
        exit("请不要上传不能被识别的文件，错误:$"."_"."FILES"." is empty");
    }
    foreach ($files as $file) {
        $tmp_name = $file['tmp_name'];
        $error = $file['error'];
        $size = $file['size'];
        $type = $file['type'];
        $name = $file['name'];
        if($error==UPLOAD_ERR_OK) {
            $ext = getExt($name);
            // 检查文件拓展名
            if (!in_array($ext, $allowExt)) {
                exit("非法文件类型");
            }
            // 检查大小
            if ($size > $maxSize) {
                exit("文件过大");
            }
            // 检查是否是使用POST HTTP方式上传
            if (!is_uploaded_file($tmp_name)) {
                exit("不是使用POST HTTP方式上传");
            }
            // 检查是否是图片类型
            if ($imgFlag && !getimagesize($tmp_name)) {
                exit("不是真正的图片类型");
            }
            $uniName = getUniName().'.'.$ext;
            $destination = $path."/".$uniName;
            if (move_uploaded_file($tmp_name, $destination)) {
                $file['name'] = $uniName;
                unset($file['tmp_name'],$file['error'],$file['size'],$file['type']);
                $uploadedFiles[$i] = $file;
                $i++;
            }
        } else {
            switch($error){
                case 1:
                    $mes="超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mes="超过了表单设置上传文件的大小";			//UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mes="文件部分被上传";//UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mes="没有文件被上传";//UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mes="没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mes="文件不可写";//UPLOAD_ERR_CANT_WRITE;
                    break;
                case 8:
                    $mes="由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                    break;
            }
            echo $mes;
        }
    }
    return $uploadedFiles;
}


function resizeImage() {
    $filename = "des_big.jpg";
    //得到文件类型
    list($src_w,$src_h,$imagetype) = getimagesize($filename);
    $mime = image_type_to_mime_type($imagetype);
    //得到方法名，通过拼接字符串得到，这样子做是为了能够处理不同类型的图片
    $createFun=str_replace("/", "createfrom", $mime);
    $outFun=str_replace("/", null, $mime);
    
    $src_image=$createFun($filename);
    $defSize = array(50,220,350,800);
    foreach ($defSize as $v) {
        $dst_image = imagecreatetruecolor($v, $v);
        imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $v, $v, $src_w, $src_h);
        $outFun($dst_image,"uploads/image_".$v."/".$filename);
        imagedestroy($dst_image);
    }
    imagedestroy($src_image);
    
}