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
    $this->url = '@file_upload?id='.$this->directory->id;
    $this->widgets = array('file');
  }

  public function executeCommunityFileUploadModal()
  {
    $this->community = $this->getRequest()->getAttribute('sf_route')->getObject();
    if (!$this->community)
    {
      throw new Exception('The community object does not specified.');
    }

    $choices = FileDirectoryQuery::getListQueryByCommunityId($this->community->id)
      ->select('id, name')
      ->fetchArray();

    $this->form = new ManagedFileForm(array(), array('directoryChoices' => $choices));
    $this->url = '@file_upload_community?id='.$this->community->id;
    $this->widgets = array('file', 'directory_id');
  }
}
