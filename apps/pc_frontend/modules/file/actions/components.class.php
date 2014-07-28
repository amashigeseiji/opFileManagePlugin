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

    $this->form = new ManagedFileForm(array(), array('directoryChoices' => $this->directory->id));
    $this->form->getWidget('directory_id')->setHidden(true);
    $this->form->getWidget('directory_id')->setDefault($this->directory->id);
    $this->url = '@file_upload?id='.$this->directory->id;
    $this->widgets = array('file');
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

    $choices = FileDirectoryQuery::getListQueryByCommunityId($community->id)
      ->select('id, name')
      ->fetchArray();

    // If no directory is created for this community.
    if (!$choices)
    {
      return sfView::NONE;
    }

    $this->form = new ManagedFileForm(array(), array('directoryChoices' => $choices));
    $this->url = '@file_upload_community?id='.$community->id;
    $this->widgets = array('file', 'directory_id');
  }

  public function executeMemberFileUploadModal()
  {
    $member = $this->getRequest()->getAttribute('sf_route')->getObject();
    if (!$member || !$member instanceof Member)
    {
      throw new Exception('The member object does not specified.');
    }

    if ($member->id !== $this->getContext()->getUser()->getMemberId())
    {
      return sfView::NONE;
    }

    $types = array('public');
    if (opFileManageConfig::isUsePrivate())
    {
      $types[] = 'private';
    }
    $choices = FileDirectoryQuery::getListQueryByMemberId($member->id, $types)
      ->select('id, name')
      ->fetchArray();

    $this->form = new ManagedFileForm(array(), array('directoryChoices' => $choices));
    $this->url = '@file_upload_member?id='.$member->id;
    $this->widgets = array('file', 'directory_id');
  }
}
