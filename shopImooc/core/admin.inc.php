<?php

/**
 * 检查是否有这个管理员
 * @param unknown $sql
 * @return Ambigous <multitype:, multitype:>
 */
function checkAdmin($sql){
    return fetchOne($sql);
}

/**
 * 检查是否有登陆
 */
function checkLogined() {
    $SAID = @$_SESSION['adminId'];
    $CAID = @$_COOKIE['adminId'];
    if ($SAID==""&&$CAID=="") {
//     if ($_SESSION['adminId']==""&&$_COOKIE['adminId']=="") {
        alertMes("请先登陆", "login.php");
    }
}

/**
 * 退出登陆
 */
function logout() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(),'',time()-1);
    }
    if (isset($_COOKIE["adminId"])) {
        setcookie("adminId",'',time()-1);
    }
    if (isset($_COOKIE["adminName"])) {
        setcookie("adminName",'',time()-1);
    }
    
    session_destroy();
    header("location:login.php");
}

/**
 * 添加管理员
 */
function addAdmin() {
    $arr = $_POST;
    $arr["password"] = md5($arr["password"]);
    if (insert("imooc_admin", $arr)) {
        $mes = "添加成功！<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
    } else {
        $mes = "添加失败！<br/><a href='addAdmin.php'>重新添加</a>";
    }
    return $mes;
}

/**
 * 得到所有的管理员
 */
function getAllAdmin() {
    $sql="select id,username,email from imooc_admin";
    $rows = fetchAll($sql);
    return $rows;
}