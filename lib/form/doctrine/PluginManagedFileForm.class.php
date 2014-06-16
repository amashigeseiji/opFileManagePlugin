<?php

/**
 * PluginManagedFile form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginManagedFileForm extends BaseManagedFileForm
{
  public function setup()
  {
    parent::setup();

    unset(
      $this['member_id'], $this['file_id'],
      $this['created_at'], $this['updated_at']
    );

    $this->widgetSchema['name'] = new sfWidgetFormInput();
    $this->widgetSchema['file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['file'] = new sfValidatorFile(array('required' => true));
  }

  public function save()
  {
    $file = new File();
    $file->setFromValidatedFile($this->getValue('file'));

    $this->getObject()->setFile($file);
    $this->getObject()->setMemberId(sfContext::getInstance()->getuser()->getMemberId());

    return parent::save();
  }
}
