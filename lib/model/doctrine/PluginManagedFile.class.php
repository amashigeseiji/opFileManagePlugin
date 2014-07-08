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
   * @return bool
   */
  public function isViewable(Member $member)
  {
    return $this->getFileDirectory()->isViewable($member);
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

  public function editName($name)
  {
    $this->setName($name);
    $this->save();
  }
}
