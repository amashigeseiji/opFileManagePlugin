<?php

/**
 * opWidgetFormSelectDirectoryType represents a community widget.
 *
 * @package    OpenPNE
 * @subpackage widget
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opWidgetFormSelectDirectoryType extends sfWidgetFormSelectRadio
{
  protected function configure($options = array(), $attributes = array())
  {
    $types = Doctrine::getTable('FileDirectory')->getTypes();
    $this->addOption('choices', $types);
    $this->setDefault('public');

    if (1 === count($types))
    {
      $this->setHidden(true);
    }

    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ($this->isHidden())
    {
      $attributes['type'] = 'hidden';
      $attributes['value'] = $this->getDefault();

      return $this->renderContentTag(
        'input',
        null,
        array_merge(array('name' => $name), $attributes)
      );
    }

    return parent::render($name, $value, $attributes, $errors);
  }
}
