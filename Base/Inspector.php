<?php
/**
 * Created by PhpStorm.
 * User: kibb
 * Date: 3/23/18
 * Time: 5:15 PM
 */
namespace Kibb\Base;
use ReflectionClass;
class Inspector{
    protected $_class;
    protected $_meta = [
        "class" => [],
        "methods" => [],
        "properties" => []
    ];

    protected $_properties =[];
    protected $_methods = [];

    public function __construct($class)
    {
        $this->_class= $class;
    }
    protected function _getClassComment(){
        $reflection = new ReflectionClass($this->_class);
        return $reflection->getDocComment();
    }

    protected function _getClassProperties(){
        $reflection = new ReflectionClass($this->_class);
        return $reflection->getProperties();
    }

    protected function _getClassMethods(){
        $reflection = new ReflectionClass($this->_class);
        return $reflection->getMethods();
    }

    protected function _getPropertyComment($property){
        $reflection = new \ReflectionProperty($this->_class, $property);
        return $reflection->getDocComment();
    }

    protected function _getMethodComment($method){
        $reflection = new \ReflectionMethod($this->_class,$method);

        return $reflection->getDocComment();
    }

    protected function _parse($comment){
        $meta = [];
        $pattern = "(@[a-zA-Z]+\s*[a-zA-Z0-9,()_]*)";
        $matches = StringMethods::match($comment,$pattern);
        
        if ($matches != null){
            foreach ($matches as $match) {
                $parts = ArrayMethods::clean(ArrayMethods::trim(
                    StringMethods::split($match,"[\s]",2)
                ));
                $meta[$parts[0]] = true;
                if (sizeof($parts) > 1){
                    $meta[$parts[0]] = ArrayMethods::clean(ArrayMethods::trim(
                        StringMethods::split($parts[1],",")
                    ));
                }
            }
            return $meta;
        }
    }

    public function getClassMeta(){
        if (!isset($_meta['class'])){
            $comment = $this->_getClassComment();
            if (!empty($comment)){
                $_meta['class'] = $this->_parse($comment);
            }else{
                $_meta['class'] = null;
            }
        }

        return $_meta['class'] ;
    }


    public function getClassProperties(){
        if (!isset($_properties)){
            $properties =$this->_getClassProperties();
            foreach ($properties as $property) {
                $_properties[] = $property->getName();
            }
        }
        return $_properties;
    }

    public function getClassMethods(){
        if (!isset($this->_methods))
        {
            $methods = $this->_getClassMethods();
            foreach ($methods as $method)
            {
                $_methods[] = $method->getName();
            }
        }
        return $_methods;
    }

    public function getPropertyMeta($property){
        if (!isset($this->_meta["properties"][$property])){
            $comment = $this->_getPropertyComment($property);
            if (!empty($comment)){
                $this->_meta["properties"][$property] = $this->_parse($comment);
            }else{
                $this->_meta["properties"][$property] = null;
            }
        }

        return $this->_meta["properties"][$property];
    }

    public function getMethodMeta($method){
        if (!isset($this->_meta["methods"][$method])){
            $comment = $this->_getMethodComment($method);
            if (!empty($comment)){
                $this->_meta["methods"][$method] = $this->_parse($comment);
            }else{
                $this->_meta["methods"][$method] = null;
            }

            return $this->_meta["methods"][$method] ;
        }
    }
}