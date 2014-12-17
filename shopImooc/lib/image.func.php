<?php
require_once 'string.func.php';
// 通过GD库做验证码
function verifyImage($type = 1, $length = 4, $pixel = 0, $line = 10, $sses_name = "verify")
{
    // 创建画布
    $width = 80;
    $height = 28;
    $image = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($image, 255, 255, 255);
    $balck = imagecolorallocate($image, 0, 0, 0);
    // 用填充矩形填充画布
    imagefilledrectangle($image, 1, 1, $width - 2, $height - 2, $white);
    $chars = buildRandomString($type, $length);
    $_SESSION[$sses_name] = $chars;
    for ($i = 0; $i < $length; $i ++) {
        $size = mt_rand(14, 18);
        $angle = mt_rand(- 15, 15);
        $x = 3 + $i * $size;
        $y = mt_rand(18, 22);
        $fontfile = "../fonts/" . "STFANGSO.TTF";
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        $text = substr($chars, $i, 1);
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
    // 加点
    for ($i = 0; $i < $pixel; $i ++) {
        imagesetpixel($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), $balck);
    }
    // 加直线
    for ($i = 0; $i < $line; $i ++) {
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        imageline($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), mt_rand(0, $width - 1), mt_rand(0, $height - 1), $color);
    }
    header("content-type:image/jpg");
    imagegif($image);
    imagedestroy($image);
}

/**
 * 生成缩略图
 * @param string $fileName
 * @param string $destination
 * @param int $dst_w
 * @param int $dst_h
 * @param number $scale
 * @param bool $isReservedSource
 * @return Ambigous <string, unknown>
 */
function thumb($fileName,$destination=null,$dst_w=null,$dst_h=null,$scale=0.5,$isReservedSource=true) {
    //得到文件类型
    list($src_w,$src_h,$imagetype) = getimagesize($fileName);
    if (is_null($dst_w)||is_null($dst_h)) {
        $dst_w = ceil($src_w*$scale);
        $dst_h = ceil($src_h*$scale);
    }
    $mime = image_type_to_mime_type($imagetype);
    //得到方法名，通过拼接字符串得到，这样子做是为了能够处理不同类型的图片
    $createFun=str_replace("/", "createfrom", $mime);
    $outFun=str_replace("/", null, $mime);

    $src_image=$createFun($fileName);
    $dst_image = imagecreatetruecolor($dst_w, $dst_h);
    imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

    $destination = $destination==null?getUniName().'.'.getExt($fileName):$destination;

    $outFun($dst_image,$destination);
    imagedestroy($dst_image);
    imagedestroy($src_image);
    if (!$isReservedSource) {
        unlink($fileName);
    }
    return $destination;
}

