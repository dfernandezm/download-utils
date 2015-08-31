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
 * Class FileManagerRequestParams
 *
 * @ExclusionPolicy("none")
 * @AccessType("public_method")
 *
 */
class FileManagerRequestParams {

 /**
  * @Type("string")
  *
  */
  private $mode;

  /**
   * @Type("boolean")
   *
   */
  private $onlyFolders;

  /**
   * @Type("string")
   *
   */
  private $path;

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getOnlyFolders()
    {
        return $this->onlyFolders;
    }

    /**
     * @param mixed $onlyFolders
     */
    public function setOnlyFolders($onlyFolders)
    {
        $this->onlyFolders = $onlyFolders;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }




}