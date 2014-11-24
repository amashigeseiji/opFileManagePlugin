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

    $this->widgetSchema['name']->setLabel('Directory name');

    $this->widgetSchema['type'] = new opWidgetFormSelectDirectoryType(array('choices' => $this->getChoices()));
    $validChoices = Doctrine::getTable('FileDirectory')->getTypes($this->getOption('allowedChoiceType'));
    $this->validatorSchema['type'] = new sfValidatorChoice(array('choices' => $validChoices));

    $this->widgetSchema['type']->setLabel('Public');

    $this->validatorSchema['note'] = new sfValidatorString(array('required' => false));

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
    $widgets = array('name', 'note');
    if (!$this['type']->isHidden())
    {
      $widgets[] = 'type';
    }
    if (opFileManageConfig::isUseCommunity() && isset($this['community_id']) && !$this['community_id']->isHidden())
    {
      $widgets[] = 'community_id';
    }

    return $widgets;
  }

  private function getChoices()
  {
    $types = Doctrine::getTable('FileDirectory')->getTypes($this->getOption('allowedChoiceType'));
    $choices = array();
    foreach ($types as $type)
    {
      $choices[$type] = $type;
    }

    return $choices;
  }
}
