<?php

/**
 * PluginFileDirectory
 *
 * @package    opFileManagedPlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginFileDirectory extends BaseFileDirectory implements opAccessControlRecordInterface
{
  private $config;
  /**
   * @return bool
   */
  public function isViewable(Member $member)
  {
    return $this->isAllowed($member, 'view');
  }

  public function isEditable(Member $member)
  {
    return $this->isAllowed($member, 'edit');
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

  public function generateRoleId(Member $member)
  {
    if ($this->getMemberId() === $member->id)
    {
      return 'author';
    }
    elseif (Doctrine::getTable('CommunityMember')->isMember($member->id, $this->getConfig()->getCommunityId()))
    {
      return 'member';
    }

    return 'everyone';
  }
}
