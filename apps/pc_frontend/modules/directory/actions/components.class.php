<?php
class directoryComponents extends sfComponents
{
  public function executeCommunityDirectoryList()
  {
    $id = sfContext::getInstance()->getRequest()->getParameter('id');
    $community = Doctrine::getTable('Community')->find($id);

    $this->pager = Doctrine::getTable('FileDirectory')->getCommunityDirectoryListPager($community->id, 4);
    $this->pager->init();
  }
}
