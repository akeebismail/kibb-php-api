<?php
/**
 * Created by PhpStorm.
 * User: kibb
 * Date: 3/23/18
 * Time: 6:46 PM
 */
namespace Kibb\Base\Configuration\Driver;

use Kibb\Base\ArrayMethods;
use Kibb\Base\Configuration\Driver;
use Kibb\Base\Configuration\Exception\Argument;
use Kibb\Base\Configuration\Exception\Syntax;

class Ini extends Driver
{
    protected function _pair($config, $key, $value)
    {
        if (strstr($key, "."))
        {
            $parts = explode(".", $key, 2);

            if (empty($config[$parts[0]]))
            {
                $config[$parts[0]] = array();
            }

            $config[$parts[0]] = $this->_pair($config[$parts[0]], $parts[1], $value);
        }
        else
        {
            $config[$key] = $value;
        }

        return $config;
    }

    public function parse($path)
    {
        if (empty($path))
        {
            return new Argument("\$path argument is not valid");
        }

        if (!isset($this->_parsed[$path]))
        {
            $config = array();

            ob_start();
            include("{$path}.ini");
            $string = ob_get_contents();
            ob_end_clean();

            $pairs = parse_ini_string($string);

            if ($pairs == false)
            {
                return new Syntax("Could not parse configuration file");
            }

            foreach ($pairs as $key => $value)
            {
                $config = $this->_pair($config, $key, $value);
            }

            $this->_parsed[$path] = ArrayMethods::toObject($config);
        }


        return $this->_parsed[$path];
    }
}