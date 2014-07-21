<?php
class fileComponents extends sfComponents
{
  public function executeDirectoryFileUploadModal()
  {
    $this->directory = $this->getRequest()->getAttribute('sf_route')->getObject();
    if (!$this->directory)
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
    if (!$community)
    {
      throw new Exception('The community object does not specified.');
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
}
