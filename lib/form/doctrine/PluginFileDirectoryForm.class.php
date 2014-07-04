<?php

/**
 * PluginFileDirectory form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginFileDirectoryForm extends BaseFileDirectoryForm
{
  public function setup()
  {
    parent::setup();
    unset(
      $this['member_id'], $this['created_at'], $this['updated_at']
    );

    if (!opFileManageConfig::get('use_private_directory'))
    {
      unset($this['is_open']);
    }

    if (opFileManageConfig::get('use_community_directory'))
    {
      $memberId = sfContext::getInstance()->getUser()->getMemberId();
      $this->setWidget('community', new opWidgetFormSelectCommunity(array('type' => 'join', 'member_id' => $memberId)));
      $this->setValidator('community', new opValidatorSelectCommunity(array('type' => 'join', 'join_member_id' => $memberId)));
    }
  }

  public function save()
  {
    $this->getObject()->setMemberId(sfContext::getInstance()->getUser()->getMemberId());

    if (!opFileManageConfig::get('use_private_directory'))
    {
      $this->getObject()->setIsOpen(true);
    }

    return parent::save();
  }
}
