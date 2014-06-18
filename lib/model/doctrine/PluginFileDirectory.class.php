<?php

/**
 * PluginFileDirectory
 *
 * @package    opFileManagedPlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginFileDirectory extends BaseFileDirectory
{
  /**
   * @return bool
   */
  public function isViewable()
  {
    return $this->isAuthor() ? true : (bool)$this->getIsOpen();
  }

  /**
   * @return bool
   */
  public function isAuthor()
  {
    return (bool)sfContext::getInstance()->getUser()->getMemberId() === $this->getMember()->getId();
  }

  /**
   * @return bool
   */
  public function getPublicLabel()
  {
    return $this->getIsOpen() ? '公開' : '非公開';
  }
}
