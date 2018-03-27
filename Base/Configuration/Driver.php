<?php
/**
 * Created by PhpStorm.
 * User: kibb
 * Date: 3/23/18
 * Time: 6:47 PM
 */
namespace Kibb\Base\Configuration;

use Kibb\Base\Base;
use Kibb\Base\Configuration\Exception\Implementation;

class Driver extends Base{
    protected $_parsed = array();

    public function initialize()
    {
        return $this;
    }

    protected function _getExceptionForImplementation($method)
    {
        return new Implementation("{$method} method not implemented");
    }
}