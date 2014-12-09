<?php
/**
 * 添加类别
 * @return string
 */
function addCate() {
    $arr=$_POST;
    if (insert("imooc_cate", $arr)) {
        $mes = "分类添加成功！<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看列表</a>";
    } else {
        $mes = "分类添加失败！<br/><a href='addCate.php'>重新添加</a>|<a href='listCate.php'>查看列表</a>";
    }
    return $mes;
}

/**
 * 删除类别
 * @param int $id
 * @return string
 */
function delCate($id) {
    if (delete("imooc_cate","id={$id}")) {
        $mes = "删除成功！<a href='listCate.php'>查看类别列表</a>";
    } else {
        $mes = "删除失败！<a href='listCate.php'>重新删除</a>";
    }
    return $mes;
}

/**
 * 修改类别
 * @param int $id
 * @return string
 */
function editCate($id) {
    $arr = $_POST;
    if (update("imooc_cate", $arr,"id={$id}")) {
        $mes = "修改成功！<a href='listCate.php'>查看类别列表</a>";
    } else {
        $mes = "修改失败！<a href='listCate.php'>重新修改</a>";
    }
    return $mes;
}
