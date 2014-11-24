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

    if (!opFileManageUtil::isCreatableCommunityDirectory($this->community, sfContext::getInstance()->getUser()->getMember()))
    {
      return sfView::NONE;
    }

    $this->pager = Doctrine::getTable('FileDirectory')->getCommunityDirectoryListPager($this->community->id, 4);
    $this->pager->init();
  }

  public function executeDirectoryCreateModal()
  {
    if (!opFileManageConfig::isUsePrivate() && !opFileManageConfig::isUsePublic())
    {
      return sfView::NONE;
    }

    $this->form = new FileDirectoryForm(array(), array('allowedChoiceType' => array('public', 'private')));

    if (opFileManageConfig::isUseCommunity())
    {
      unset($this->form['community_id']);
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
