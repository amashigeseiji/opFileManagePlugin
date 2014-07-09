<?php

/**
 * opWidgetFormSelectCommunity represents a community widget.
 *
 * @package    OpenPNE
 * @subpackage widget
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opWidgetFormSelectCommunity extends sfWidgetFormSelect
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('type', $options['type']);
    $this->addOption('member_id', $options['member_id']);
    if ('join' === $options['type'])
    {
      $this->addOption('choices', array_merge(array(null), $this->getJoinCommunityChoices()));
    }
  }

  protected function getJoinCommunityChoices()
  {
    $choices = array();
    $joinCommunity = Doctrine::getTable('Community')
      ->retrievesByMemberId($this->getOption('member_id'), null);

    foreach ($joinCommunity as $community)
    {
      $choices[$community->id] = $community->name;
    }

    return $choices;
  }
}
