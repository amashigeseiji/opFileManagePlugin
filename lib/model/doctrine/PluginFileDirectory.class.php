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

  public function isUploadable(Member $member)
  {
    return $this->isAllowed($member, 'upload');
  }

  public function isDeletable(Member $member)
  {
    return $this->isAllowed($member, 'delete');
  }

  /**
   * @return bool
   */
  public function isAuthor(Member $member = null)
  {
    $member = $member ? $member : sfContext::getInstance()->getUser()->getMember();
    $roleId = $this->generateRoleId($member);

    return (bool)('author' === $roleId || 'admin' === $roleId);
  }

  /**
   * @return bool
   */
  public function getPublicLabel()
  {
    return ucfirst($this->type);
  }

  /**
   * @param string $publish 公開フラグ
   */
  public function publish($publish)
  {
    if (opFileManageConfig::isUsePrivate())
    {
      $validator = new sfValidatorChoice(array('choices' => Doctrine::getTable('FileDirectory')->getTypes(), 'required' => true));
      try
      {
        $this->setType($validator->clean($publish));
        $this->save();
      }
      catch (sfValidatorError $e)
      {
        throw $e;
      }
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
    if (!opFileManageConfig::isUsePrivate() && 'private' === $this->type
    || !opFileManageConfig::isUseCommunity() && 'community' === $this->type)
    {
      return 'reject';
    }

    if (opFileManageConfig::isUseCommunity() && 'community' === $this->type)
    {
      $community = $this->getConfig()->getCommunity();
      if ($community->isAdmin($member->id))
      {
        return 'admin';
      }
      elseif ($community->isPrivilegeBelong($member->id))
      {
        if ('public' === $community->getConfig('directory_authority') && $this->getMemberId() === $member->id)
        {
          return 'author';
        }

        return 'member';
      }

      return 'everyone';
    }

    # public or private directory
    return ($this->getMemberId() === $member->id) ? 'admin' : 'everyone';
  }

  /**
   * @return bool
   */
  public function isPrivate()
  {
    return 'private' === $this->type;
  }
}
