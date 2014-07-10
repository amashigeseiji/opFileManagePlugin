<?php
class directoryComponents extends sfComponents
{
  public function executeCommunityDirectoryList()
  {
    $this->isCommunityMember = Doctrine::getTable('CommunityMember')->isMember(sfContext::getInstance()->getUser()->getMemberId(), $this->community->id);

    if ($this->isCommunityMember)
    {
      $this->pager = Doctrine::getTable('FileDirectory')->getCommunityDirectoryListPager($this->community->id, 4);
      $this->pager->init();
    }
  }
}
