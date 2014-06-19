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
    return sfContext::getInstance()->getUser()->getMemberId() === $this->getMember()->getId();
  }

  /**
   * @return bool
   */
  public function getPublicLabel()
  {
    return $this->getIsOpen() ? '公開' : '非公開';
  }

  /**
   * @param bool|null $publish 公開フラグ
   */
  public function publish($publish = null)
  {
    $this->setIsOpen($publish ? true : false);
    $this->save();
  }

  public function modifyName($name)
  {
    $this->setName($name);
    $this->save();
  }
}
