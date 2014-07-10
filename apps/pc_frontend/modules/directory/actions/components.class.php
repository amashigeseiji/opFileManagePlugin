<?php
class directoryComponents extends sfComponents
{
  public function executeCommunityDirectoryList()
  {
    $isCommunityMember = Doctrine::getTable('CommunityMember')->isMember(sfContext::getInstance()->getUser()->getMemberId(), $this->community->id);

    if (!$isCommunityMember)
    {
      return sfView::NONE;
    }

    $this->pager = Doctrine::getTable('FileDirectory')->getCommunityDirectoryListPager($this->community->id, 4);
    $this->pager->init();
  }
}
