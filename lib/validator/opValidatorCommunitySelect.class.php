<?php

/**
 * opValidatorSelectCommunity validates a community
 *
 * @package    OpenPNE
 * @subpackage validator
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opValidatorSelectCommunity extends sfValidatorBase
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('type', $options['type']);
    $this->addOption('join_member_id', $options['join_member_id']);
  }

  protected function doClean($value)
  {
    if ('join' == $this->getOption('type'))
    {
      if (Doctrine::getTable('CommunityMember')->isMember($this->getOption('join_member_id'), $value))
      {
        return $value;
      }

      return false;
    }

    return false;
  }
}
