<?php
/*
 * 打印方法集合类
 */
namespace App\Http\Tools;

use ReflectionClass;

class Logs
{
    public static function logObj($obj)
    {
/*            //打印查询对象中的属性值
            //获取传入对象的类名
            $class_name = get_class($obj);
            //实例化对象的反射
            $reflector = new ReflectionClass($class_name);
            //获取对象的所有属性
            $properties = $reflector->getProperties();
            $i = 1;
            //获取所有属性
            foreach ($properties as $property) {
                //Populating properties
                $obj->{$property->getName()} = $i;

                //Invoking the method to print what was populated
                $obj->{"echo" . ($property->getName())}() . "\n";
                $i++;
            }*/

        return (json_encode($obj));

    }

}
