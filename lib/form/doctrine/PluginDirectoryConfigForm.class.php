<?php

/**
 * PluginDirectoryConfig form.
 *
 * @package    opFileManagedPlugin
 * @subpackage form
 * @author     Seiji Amashige
 */
abstract class PluginDirectoryConfigForm extends BaseDirectoryConfigForm
{
  public function setup()
  {
    parent::setup();

    unset(
      $this['community_id'], $this['directory_id']
    );

    $memberId = sfContext::getInstance()->getUser()->getMemberId();
    $this->setWidget('community_id', new opWidgetFormSelectCommunity(array('type' => 'join', 'member_id' => $memberId)));
    $this->setValidator('community_id', new opValidatorSelectCommunity(array('type' => 'join', 'join_member_id' => $memberId)));
  }

  public function save()
  {
    $directoryConfig = $this->getOption('directory')->getConfig();
    if ($directoryConfig->has('community_id'))
    {
      return $directoryConfig->updateCommunityId($this->getValue('community_id'));
    }
    else
    {
      return $directoryConfig->create($this->getValue('community_id'));
    }
  }
}
