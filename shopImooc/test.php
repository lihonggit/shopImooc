<?php
class Car {
    private $ary = array();

    public function __set($key, $val) {
        $this->ary[$key] = $val;
    }

    public function __get($key) {
        if (isset($this->ary[$key])) {
            return $this->ary[$key];
        }
        return null;
    }

    public function __isset($key) {
        if (isset($this->ary[$key])) {
            return true;
        }
        return false;
    }

    public function __unset($key) {
        unset($this->ary[$key]);
    }
}
// $car = new Car();
// $car->name = 'hehe';  //name属性动态创建并赋值
// $car->name2 = 'hehe';  //name属性动态创建并赋值
// $car->name3 = 'hehe';  //name属性动态创建并赋值
// echo $car->name;
// echo $car->name2;
// echo $car->name3;
$arr = array(2,3,4);
echo "<b>".var_dump( isset($b))."</b>";

header("content-type:text/html");

    