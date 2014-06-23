<?php

/**
 * PluginDirectoryConfig form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginDirectoryConfigForm extends BaseDirectoryConfigForm
{
  public function setup()
  {
    parent::setup();

    unset($this['directory_id'], $this['name'], $this['value']);
    $this->widgetSchema['member_id'] = new sfWidgetFormInputText();
    $this->validatorSchema['member_id'] = new sfValidatorNumber(array('required' => true));
  }

  public function save()
  {
    $this->getObject()->setDirectoryId($this->getOption('directory')->getId());
    $this->getObject()->setName('member_id');
    $this->getObject()->setValue($this->getValue('member_id'));

    parent::save();
  }
}
