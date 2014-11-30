<?php
require_once 'string.func.php';
// ͨ��GD������֤��
function verifyImage($type=1,$length=4,$pixel=0,$line=10,$sses_name="verify")
{
//     session.stat();
    // ��������
    $width = 80;
    $height = 28;
    $image = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($image, 255, 255, 255);
    $balck = imagecolorallocate($image, 0, 0, 0);
    // ����������仭��
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
    // �ӵ�
    for ($i = 0; $i < $pixel; $i ++) {
        imagesetpixel($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), $balck);
    }
    // ��ֱ��
    for ($i = 0; $i < $line; $i ++) {
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        imageline($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), mt_rand(0, $width - 1), mt_rand(0, $height - 1), $color);
    }
    header("content-type:image/gif");
    imagegif($image);
    imagedestroy($image);
}
verifyImage();

?>