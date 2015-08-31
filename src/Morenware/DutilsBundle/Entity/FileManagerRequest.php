<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 31/08/2015
 * Time: 21:57
 */

namespace Morenware\DutilsBundle\Entity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;

//{ "params": {
//    "mode": "list",
//    "onlyFolders": false,
//    "path": "/public_html"
//}}

/**
 * Class FileManagerRequest
 *

 *
 * @package Morenware\DutilsBundle\Entity
 */
class FileManagerRequest {

  private $params;

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}