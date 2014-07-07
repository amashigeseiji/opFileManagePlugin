<?php

/**
 * PluginFileDirectory
 *
 * @package    opFileManagedPlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginFileDirectory extends BaseFileDirectory
{
  private $config;
  /**
   * @return bool
   */
  public function isViewable()
  {
    if ($this->isAuthor())
    {
      return true;
    }

    if (opFileManageConfig::get('use_community_directory')
     && $communityId = $this->getConfig()->getCommunityId())
    {
      $memberId = sfContext::getInstance()->getUser()->getMemberId();

      return Doctrine::getTable('CommunityMember')
        ->isMember($memberId, $communityId);
    }

    return (bool)$this->getIsOpen();
  }

  /**
   * @return bool
   */
  public function isAuthor()
  {
    return sfContext::getInstance()->getUser()->getMemberId() === $this->getMemberId();
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
    if (opFileManageConfig::get('use_private_directory'))
    {
      $this->setIsOpen($publish ? true : false);
      $this->save();
    }
  }

  public function modifyName($name)
  {
    $this->setName($name);
    $this->save();
  }

  public function getConfig()
  {
    if (!$this->config)
    {
      $this->config = new opDirectoryConfig($this->id);
    }

    return $this->config;
  }
}
