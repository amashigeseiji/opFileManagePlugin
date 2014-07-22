<?php
class opFileManageUtil
{
  static public function isViewableCommunityFile($community, $member)
  {
    if ('public' === $community->getConfig('file_public_flag'))
    {
      return true;
    }
    else
    {
      return Doctrine::getTable('CommunityMember')
        ->isMember($member->id, $community->id);
    }
  }

  static public function isCreatableCommunityDirectory($community, $member)
  {
    if ('public' === $community->getConfig('directory_authority'))
    {
      return Doctrine::getTable('CommunityMember')
        ->isMember($member->id, $community->id);
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
