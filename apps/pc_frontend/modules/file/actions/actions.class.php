<?php

/**
 * file actions.
 *
 * @package    OpenPNE
 * @subpackage file
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class fileActions extends sfActions
{
 /**
  * Executes upload action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeUpload(sfWebRequest $request)
  {
    $this->form = new ManagedFileForm();
  }

 /**
  * Executes create action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new ManagedFileForm();
    $file = $this->processForm($request, $this->form);

    if ($file)
    {
      $this->getUser()->setFlash('notice', 'ファイルをアップロードしました。');
      $this->redirect('@file_show?id='.$file->id);
    }

    $this->setTemplate('upload');
  }

 /**
  * Executes edit action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $this->file = $this->getRoute()->getObject();
    $this->forward404If(!$this->file->isAuthor());
    $this->form = new ManagedFileForm($this->file);
  }

 /**
  * Executes update action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeUpdate(sfWebRequest $request)
  {
    $file = $this->getRoute()->getObject();
    $this->form = new ManagedFileForm($file);
    $this->forward404If(!$file->isAuthor());

    $this->file = $this->processForm($request, $this->form);

    if ($this->file)
    {
      $this->getUser()->setFlash('notice', 'ファイルを編集しました。');
      $this->redirect('@file_show?id='.$file->id);
    }

    $this->setTemplate('edit');
  }

 /**
  * Executes show action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->file = $this->getRoute()->getObject();
    $this->forward404If(!$this->file->isViewable($this->getUser()->getMemberId()));
  }

 /**
  * Executes download action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeDownload(sfWebRequest $request)
  {
    $file = $this->getRoute()->getObject();
    $this->forward404If(!$file->isViewable());
    $data = $file->getFile()->getFileBin()->getBin();

    $this->getResponse()->setHttpHeader('Content-Type', $file->getFile()->getType());
    $this->getResponse()->setHttpHeader('Content-Length', strlen($data));

    $filename = $file->getFileNameWithExtension();
    // for ie
    if (1 === preg_match('/MSIE/', $request->getHttpHeader('User-Agent')))
    {
      $filename = mb_convert_encoding($filename, 'sjis-win', 'utf8');
    }
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');

    return $this->renderText($data);
  }

 /**
  * process form
  *
  * @param sfWebRequest $request A request object
  * @param sfForm $form A form object
  */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName()),
      $request->getFiles($form->getName())
    );

    if ($form->isValid())
    {
      return $form->save($directory);
    }
  }
}
