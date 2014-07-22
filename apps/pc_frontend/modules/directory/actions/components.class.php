<?php
class directoryComponents extends sfComponents
{
  public function executeCommunityDirectoryList()
  {
    if (!opFileManageConfig::isUseCommunity())
    {
      return sfView::NONE;
    }

    if (!opFileManageUtil::isViewableCommunityFile($this->community, sfContext::getInstance()->getUser()->getMember()))
    {
      return sfView::NONE;
    }

    $this->pager = Doctrine::getTable('FileDirectory')->getCommunityDirectoryListPager($this->community->id, 4);
    $this->pager->init();
  }

  public function executeSmtCommunityDirectoryList()
  {
    if (!opFileManageConfig::isUseCommunity())
    {
      return sfView::NONE;
    }

    if (!$this->getRequest()->isSmartphone())
    {
      return sfView::NONE;
    }

    $this->community = Doctrine::getTable('Community')->find($this->getRequest()->getParameter('id'));

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
    if (isset($choices['community']))
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

    if (!$this->community)
    {
      $this->community = $this->getRequest()->getAttribute('sf_route')->getObject();
    }

    if (!$this->community || !$this->community instanceof Community)
    {
      throw new opRuntimeException('CommunityDirectoryCreateModal: Community object does not set.');
    }

    if (!opFileManageUtil::isCreatableCommunityDirectory($this->community, sfContext::getInstance()->getUser()->getMember()))
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
