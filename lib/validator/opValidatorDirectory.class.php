<?php

/**
 * opValidatorDirectory validates a directory
 *
 * @package    OpenPNE
 * @subpackage validator
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opValidatorDirectory extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('privilege');
    $this->addRequiredOption('member');
  }

  protected function doClean($value)
  {
    $directory = Doctrine::getTable('FileDirectory')->find($value);

    if (!$directory)
    {
      throw new sfValidatorError($this, 'Requested directory id does not exit.');
    }

    switch ($this->getOption('privilege'))
    {
      case 'view':
        $method = 'isViewable';
        break;
      case 'upload':
        $method = 'isUploadable';
        break;
      case 'edit':
        $method = 'isEditable';
        break;
      case 'delete':
        $method = 'isDeletable';
        break;
      default:
        throw new LogicException(__METHOD__.': privilege option is invalid.');
    }

    if (!(($member = $this->getOption('member')) instanceof Member))
    {
      throw new LogicException(__METHOD__.': member option is not Member instance.');
    }

    if ($directory->$method($member))
    {
      return $directory->id;
    }

    throw new sfValidatorError($this, 'Member privilege does not belong to directory. MemberId: '.$member->id.', DirectoryId: '.$directory->id);
  }
}
