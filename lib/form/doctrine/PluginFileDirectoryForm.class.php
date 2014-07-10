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

    $this->widgetSchema['type'] = new opWidgetFormSelectDirectoryType();
    $this->validatorSchema['type'] = new sfValidatorChoice(array('choices' => Doctrine::getTable('FileDirectory')->getTypes()));

    if (opFileManageConfig::isUseCommunity())
    {
      $memberId = sfContext::getInstance()->getUser()->getMemberId();
      $this->setWidget('community_id', new opWidgetFormSelectCommunity(array('type' => 'join', 'member_id' => $memberId)));
      $this->setValidator('community_id', new opValidatorSelectCommunity(array('type' => 'join', 'join_member_id' => $memberId, 'required' => false)));
      $this->mergePostValidator(new opFileDirectoryValidatorSchema());
    }
  }

  public function save()
  {
    $this->getObject()->setMemberId(sfContext::getInstance()->getUser()->getMemberId());

    $result = parent::save();

    if ('community' === $this->getValue('type'))
    {
      $directoryConfig = $this->getObject()->getConfig();

      if ($directoryConfig->has('community_id'))
      {
        $directoryConfig->updateCommunityId($this->getValue('community_id'));
      }
      else
      {
        $directoryConfig->create($this->getValue('community_id'));
      }
    }

    return $result;
  }

  /**
   * @return array
   */
  public function getRenderWidgetNames()
  {
    $widgets = array('name');
    if (!$this['type']->isHidden())
    {
      $widgets[] = 'type';
    }
    if (opFileManageConfig::isUseCommunity())
    {
      $widgets[] = 'community_id';
    }

    return $widgets;
  }
}
