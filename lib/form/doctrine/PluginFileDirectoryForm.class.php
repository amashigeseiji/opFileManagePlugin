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


    if (opFileManageConfig::get('use_community_directory'))
    {
      $memberId = sfContext::getInstance()->getUser()->getMemberId();
      $this->setWidget('community_id', new opWidgetFormSelectCommunity(array('type' => 'join', 'member_id' => $memberId)));
      $this->setValidator('community_id', new opValidatorSelectCommunity(array('type' => 'join', 'join_member_id' => $memberId, 'required' => false)));
    }
  }

  public function save()
  {
    $this->getObject()->setMemberId(sfContext::getInstance()->getUser()->getMemberId());

    $result = parent::save();

    if (opFileManageConfig::get('use_community_directory')
      && $communityId = $this->getValue('community_id'))
    {
      $directoryConfig = $this->getObject()->getConfig();

      if ($directoryConfig->has('community_id'))
      {
        $directoryConfig->updateCommunityId($communityId);
      }
      else
      {
        $directoryConfig->create($communityId);
      }
    }

    return $result;
  }
}
