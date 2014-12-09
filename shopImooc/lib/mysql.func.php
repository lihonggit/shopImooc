<?php

/**
 * 连接数据库
 * @return resource
 */
function connect()
{
    $link = mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("数据库连接失败Error:" . mysql_errno() . ":" . mysql_error());
    mysql_set_charset(DB_CHARSET);
    mysql_select_db(DB_DBNAME) or die("指定数据库打开失败");
    return $link;
}

/**
 * 完成记录插入操作
 *
 * @param unknown $table            
 * @param unknown $array            
 * @return number
 */
function insert($table, $array)
{
    $keys = join(",", array_keys($array));
    $vals = "'" . join("','", array_values($array)) . "'";
    $sql = "insert {$table}($keys) values($vals)";
    mysql_query($sql);
    return mysql_insert_id();
}

/**
 * 更新的操作
 *
 * @param unknown $table            
 * @param unknown $array            
 * @param string $where            
 * @return number
 */
function update($table, $array, $where = null)
{
    $str = null;
    foreach ($array as $key => $val) {
        if ($str == null) {
            $sep = "";
        } else {
            $sep = ",";
        }
        $str .= $sep . $key . "='" . $val . "'";
    }
    $sql = "update {$table} set {$str} " . ($where == null ? null : "where " . $where);
    $result = mysql_query($sql);
    if ($result) {
        return mysql_affected_rows();
    } else {
        return false;
    }
}

/**
 * 删除操作
 *
 * @param unknown $table            
 * @param string $where            
 * @return number
 */
function delete($table, $where = null)
{
    $where = $where == null ? null : " where " . $where;
    $sql = "delete from {$table} {$where}";
    mysql_query($sql);
    return mysql_affected_rows();
}

/**
 * 得到指定都一条数据
 *
 * @param unknown $sql            
 * @param string $result_type            
 * @return multitype:
 */
function fetchOne($sql, $result_type = MYSQL_ASSOC)
{
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result, $result_type);
    return $row;
}

/**
 * 得到结果集
 *
 * @param unknown $sql            
 * @param string $result_type            
 * @return multitype:
 */
function fetchAll($sql, $result_type = MYSQL_ASSOC)
{
    $rows = array();
    $result = mysql_query($sql);
    while (@$row = mysql_fetch_array($result, $result_type)) {
        $rows[] = $row;
    }
    return $rows;
}

/**
 * 得到结果集记录条数
 *
 * @param unknown $sql            
 * @return number
 */
function getResultNum($sql)
{
    $result = mysql_query($sql);
    return mysql_num_rows($result);
}

