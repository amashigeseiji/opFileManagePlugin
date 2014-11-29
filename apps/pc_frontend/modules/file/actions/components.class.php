<?php
class fileComponents extends sfComponents
{
  public function executeDirectoryFileUploadModal()
  {
    $this->directory = $this->getRequest()->getAttribute('sf_route')->getObject();
    if (!$this->directory || !$this->directory instanceof FileDirectory)
    {
      throw new Exception('The directory object does not specified.');
    }

    $this->form = new ManagedFileForm(array(), array('type' => 'directory', 'directory_id' => $this->directory->id));
    $this->url = '@file_upload?id='.$this->directory->id;
    $this->widgets = array('file', 'note');
  }

  public function executeCommunityFileUploadModal()
  {
    $community = $this->getRequest()->getAttribute('sf_route')->getObject();
    if (!$community || !$community instanceof Community)
    {
      throw new Exception('The community object does not specified.');
    }

    if (!opFileManageUtil::isUploadableCommunityFile($community, sfContext::getInstance()->getUser()->getMember()))
    {
      return sfView::NONE;
    }

    // If no directory is created for this community.
    if (0 === FileDirectoryQuery::getListQueryByCommunityId($community->id)->count())
    {
      return sfView::NONE;
    }

    $this->form = new ManagedFileForm(array(), array('type' => 'community_directory', 'community_id' => $community->id));
    $this->url = '@file_upload_community?id='.$community->id;
    $this->widgets = array('file', 'directory_id', 'note');
  }

  public function executeMemberFileUploadModal()
  {
    $member = $this->getRequest()->getAttribute('sf_route')->getObject();
    if (!$member || !$member instanceof Member)
    {
      throw new Exception('The member object does not specified.');
    }

    if ($member->id !== $this->getContext()->getUser()->getMemberId()
    || !FileDirectoryTable::getInstance()->hasDirectory($member->id))
    {
      return sfView::NONE;
    }

    $this->form = new ManagedFileForm(array(), array('type' => 'member_directory', 'member_id' => $member->id));
    $this->url = '@file_upload_member?id='.$member->id;
    $this->widgets = array('file', 'directory_id', 'note');
  }
}
