<?php

/**
 * PluginManagedFile
 *
 * @package    opFileManagedPlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginManagedFile extends BaseManagedFile
{
  /**
   * @return string
   */
  public function getFileNameWithExtension()
  {
    return $this->getName().'.'.$this->getExtension();
  }

  /**
   * @return string
   */
  public function getExtension()
  {
    $filename = $this->getFile()->getOriginalFilename();

    return substr($filename, strrpos($filename, '.') + 1);
  }

  /**
   * @return bool
   */
  public function isViewable()
  {
    return $this->isAuthor() ? true : (bool)$this->getFileDirectory()->getIsOpen();
  }

  /**
   * @return bool
   */
  public function isAuthor()
  {
    return (bool)sfContext::getInstance()->getUser()->getMemberId() === $this->getMember()->getId();
  }
}
