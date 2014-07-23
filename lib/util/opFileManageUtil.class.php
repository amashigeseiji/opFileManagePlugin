<?php
class opFileManageUtil
{
  static public function isViewableCommunityFile($community, $member)
  {
    if ('public' === $community->getConfig('file_public_flag'))
    {
      // all sns members can view
      return true;
    }
    else
    {
      return $community->isPrivilegeBelong($member->id);
    }
  }

  static public function isCreatableCommunityDirectory($community, $member)
  {
    if ('public' === $community->getConfig('directory_authority'))
    {
      return $community->isPrivilegeBelong($member->id);
    }
    else
    {
      return $community->isAdmin($member->id);
    }
  }

  static public function isUploadableCommunityFile($community, $member)
  {
    if ('public' === $community->getConfig('file_authority'))
    {
      return $community->isPrivilegeBelong($member->id);
    }
    else
    {
      return $community->isAdmin($member->id);
    }
  }

  static public function setLocalNav($navType, $navId)
  {
    sfConfig::set('sf_nav_type', $navType);
    sfConfig::set('sf_nav_id', $navId);
  }
}
