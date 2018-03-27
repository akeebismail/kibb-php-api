<?php
/**
 * Created by PhpStorm.
 * User: kibb
 * Date: 3/23/18
 * Time: 6:43 PM
 */
namespace Kibb\Base;

use Kibb\Base\Configuration\Exception\Argument;
use Kibb\Base\Configuration\Exception\Implementation;

class Configuration extends Base
{
    /**
     * @readwrite
     */
    protected $_type;

    /**
     * @readwrite
     */
    protected $_options;

    protected function _getExceptionForImplementation($method)
    {
        return new Implementation("{$method} method not implemented");
    }


    public function initialize()
    {
        //Events::fire("framework.configuration.initialize.before", array($this->type, $this->options));

        if (!$this->type)
        {
            return new Argument("Invalid type");
        }

        //Events::fire("framework.configuration.initialize.after", array($this->type, $this->options));

        switch ($this->type)
        {
            case "ini":
                {
                    return new Configuration\Driver\Ini($this->options);
                    break;
                }
            default:
                {
                    return new Argument("Invalid type");
                    break;
                }
        }
    }
}