<?php
class directoryComponents extends sfComponents
{
  public function executeCommunityDirectoryList()
  {
    if (!opFileManageConfig::isUseCommunity())
    {
      return sfView::NONE;
    }

    $isCommunityMember = Doctrine::getTable('CommunityMember')->isMember(sfContext::getInstance()->getUser()->getMemberId(), $this->community->id);

    if (!$isCommunityMember)
    {
      return sfView::NONE;
    }

    $this->pager = Doctrine::getTable('FileDirectory')->getCommunityDirectoryListPager($this->community->id, 4);
    $this->pager->init();
  }

  public function executeDirectoryCreateModal()
  {
    $choices = Doctrine::getTable('FileDirectory')->getTypes();
    if ($choices['community'])
    {
      unset($choices['community']);
    }

    $this->form = new FileDirectoryForm(array(), array('directoryTypeChoices' => $choices));
    if (opFileManageConfig::isUseCommunity())
    {
      $this->form->getWidget('community_id')->setHidden(true);
      $this->form->getWidget('community_id')->setDefault(null);
    }
  }

  public function executeCommunityDirectoryCreateModal()
  {
    if (!opFileManageConfig::isUseCommunity())
    {
      return sfView::NONE;
    }

    $this->form = new FileDirectoryForm();
    $this->form->getWidget('type')->setHidden(true);
    $this->form->getWidget('type')->setDefault('community');
    $this->form->getWidget('community_id')->setHidden(true);
    $this->form->getWidget('community_id')->setDefault($this->community->id);
  }
}
