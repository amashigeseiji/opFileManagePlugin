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
    if (!opFileManageConfig::isUsePrivate() && 'private' === $this->FileDirectory->type
    || !opFileManageConfig::isUseCommunity() && 'community' === $this->FileDirectory->type)
    {
      return 'reject';
    }

    if ('community' === $this->FileDirectory->type)
    {
      $community = $this->FileDirectory->getConfig()->getCommunity();

      if ($community->isPrivilegeBelong($member->id))
      {
        if ($community->getAdminMember()->id === $member->id || $this->member_id === $member->id)
        {
          return 'author';
        }
        else
        {
          return 'member';
        }
      }
    }
    else if ('private' === $this->FileDirectory->type)
    {
      if ($this->FileDirectory->member_id === $member->id)
      {
        return 'author';
      }
    }
    else
    {
      if ($this->member_id === $member->id || $this->FileDirectory->member_id === $member->id)
      {
        return 'author';
      }
    }

    return 'everyone';
  }
}
