<?php

/**
 * opWidgetFormSelectDirectory represents a community widget.
 *
 * @package    OpenPNE
 * @subpackage widget
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opWidgetFormSelectDirectory extends sfWidgetFormSelect
{
  protected function configure($options = array(), $attributes = array())
  {
    if (1 === count($options['choices']))
    {
      $this->setHidden(true);
      $this->setDefault($options['choices']);
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

    $choices = $this->getChoices();

    $options = array();
    foreach ($choices as $key => $option)
    {
      $attributes = array('value' => self::escapeOnce($option['id']));
      $options[] = $this->renderContentTag('option', self::escapeOnce($option['name']), $attributes);
    }

    return $this->renderContentTag('select', "\n".implode("\n", $options)."\n", array_merge(array('name' => $name), $attributes));
  }
}
