<?php
class opFileManagePluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('op_action.pre_execute', array($this, 'addSmartphoneHelper'));
  }

  public function addSmartphoneHelper()
  {
    $context = sfContext::getInstance();
    $request = $context->getRequest();
    if ($request->isSmartphone())
    {
      $context->getConfiguration()->loadHelpers(array('opAsset'));
    }
  }
}
