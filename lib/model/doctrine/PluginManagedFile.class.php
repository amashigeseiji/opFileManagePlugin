<?php

/**
 * PluginManagedFile
 *
 * @package    opFileManagedPlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginManagedFile extends BaseManagedFile implements opAccessControlRecordInterface
{
  /**
   * @return bool
   */
  public function isViewable(Member $member)
  {
    return $this->isAllowed($member, 'view');
  }

  /**
   * @return bool
   */
  public function isEditable(Member $member)
  {
    return $this->isAllowed($member, 'edit');
  }

  /**
   * @return bool
   */
  public function isDeletable(Member $member)
  {
    return $this->isAllowed($member, 'delete');
  }

  /**
   * @return bool
   */
  public function isMovable(Member $member)
  {
    if ($this->isEditable($member))
    {
      return !$this->isCommunity() || opFileManageUtil::isCreatableCommunityDirectory($this->community, $member);
    }

    return false;
  }

  /**
   * @return bool
   */
  public function isAuthor()
  {
    return sfContext::getInstance()->getUser()->getMemberId() === $this->getMember()->getId();
  }

  /**
   * @return string
   */
  public function getFilesize()
  {
    $size = $this->getFile()->getFilesize();
    $units = array(' B', ' KB', ' MB', ' GB');
    for ($i = 0; $size >= 1024 && $i < 3; $i++)
    {
      $size /= 1024;
    }

    return round($size, 2).$units[$i];
  }

  /**
   * @return bool
   */
  public function isImage()
  {
    return $this->getFile()->isImage();
  }

  /**
   * @return bool
   */
  public function isText()
  {
    $type = $this->getFile()->getType();
    if ($type === 'text/plain'
      || $type === 'text/html')
    {
      return true;
    }

    return false;
  }

  public function getBin()
  {
    return $this->getFile()->getFileBin()->bin;
  }

  public function getDirectory()
  {
    return $this->FileDirectory;
  }

  public function getCommunity()
  {
    if ($this->isCommunity())
    {
      return $this->directory->config->getCommunity();
    }

    return null;
  }

  public function isCommunity()
  {
    return 'community' === $this->directory->type;
  }

  /**
   * @return string|false
   */
  public function getText()
  {
    if (!$this->isText())
    {
      return false;
    }

    return mb_convert_encoding($this->getBin(), 'UTF-8', 'auto');
  }

  public function editName($name)
  {
    $this->setName($name);
    $this->save();
  }

  public function generateRoleId(Member $member)
  {
    $directoryRoleId = $this->FileDirectory->generateRoleId($member);

    if ('reject' === $directoryRoleId || 'author' === $directoryRoleId || 'admin' === $directoryRoleId)
    {
      return $directoryRoleId;
    }
    elseif ($this->member_id === $member->id)
    {
      return 'author';
    }

    return 'everyone';
  }

  public function moveDirectory($directoryId)
  {
    $this->setDirectoryId($directoryId);
    $this->save();
  }
}
