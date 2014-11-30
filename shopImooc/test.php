<?php
function  hehe() {
    header("content-type:text/html;charset=utf-8");

    $table = "pig";
    $array = array('name'=>"杨眉","type"=>"猪","sex"=>"雌");
    $keys=join(",",array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert {$table}($keys) values($vals)";
    echo $sql;
    echo "<br>";
    
    
    $where = "你妈逼";
//     $str = null;
    foreach ($array as $key => $val) {
        if ($str==null) {
            $sep="";
        }else {
            $sep=",";
        }
        $str.=$sep.$key."='".$val."'";
        $sql = "update {$table} set {$str} ".($where==null?null:"where ".$where).";";
    }
    echo  $sql;
}
hehe();
    