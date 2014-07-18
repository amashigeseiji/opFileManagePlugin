<?php

/**
 * opValidatorDirectory validates a community
 *
 * @package    OpenPNE
 * @subpackage validator
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opValidatorDirectory extends sfValidatorBase
{
  protected function doClean($value)
  {
    $directory = Doctrine::getTable('FileDirectory')->find($value);

    if (!$directory)
    {
      throw new sfValidatorError($this, 'Requested directory id does not exit.');
    }

    $member = sfContext::getInstance()->getUser()->getMember();

    if ($directory->isUploadable($member))
    {
      return $value;
    }

    throw new sfValidatorError($this, 'Member  privilege does not belong to directory. MemberId: '.$member->id.', DirectoryId: '.$directory->id);
  }
}
