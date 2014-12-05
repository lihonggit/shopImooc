<?php
require_once '../include.php';
$username=$_POST["username"];
$password=md5($_POST["password"]);
$verify=$_POST["verify"];
$verify1=$_SESSION["verify"];
@$autoFlag=$_POST["autoFlag"];
if ($verify==$verify1) {
    $sql="select * from imooc_admin where username = '{$username}'and password = '{$password}'";
    $res=fetchOne($sql);
    if ($res) {
        // 选择了一周自动登陆
        if ($autoFlag){
            setcookie("adminId",$res['id'],time()+7*24*3600);
            setcookie("adminName",$res['username'],time()+7*24*3600);
        }
        $_SESSION["adminName"] = $res["username"];
        $_SESSION['adminId'] = $res["id"];
        alertMes("登陆成功", "index.php");
    } else {
        alertMes("登陆失败，重新登陆", "login.php");
    }
} else {
    alertMes("验证码错误，重新登陆", "login.php");
}
