<?php

/**
 * ManagedFileQuery
 *
 */
class ManagedFileQuery extends Doctrine_Query
{
  static public function create($conn = null, $class = null)
  {
    return parent::create($conn, 'ManagedFileQuery')
      ->from('ManagedFile');
  }

  public function addDirectoryId($directoryId)
  {
    return $this->andWhere('directory_id = ?', $directoryId);
  }

  public function addMemberId($memberId)
  {
    return $this->andWhere('member_id = ?', $memberId);
  }

  public function addOrderBy($orderBy = null)
  {
    return $this->orderBy($orderBy ? $orderBy : 'created_at DESC');
  }

  public static function getFileListQueryByDirectoryId($directoryId)
  {
    return self::create()
      ->addOrderBy()
      ->addDirectoryId($directoryId);
  }

  /**
   * @param community_id
   * @return Doctrine_Query コミュニティで共有しているファイル一覧を取得するクエリ
   */
  public static function getCommunityFileListQuery($communityId)
  {
    $directoryIds = Doctrine::getTable('DirectoryConfig')->getDirectoryIdsByCommunityId($communityId);

    return Doctrine_Query::create()
      ->from('ManagedFile')
      ->whereIn('directory_id', $directoryIds);
  }

  public static function getMemberFileListQuery($memberId)
  {
    $q = Doctrine_Query::create()
      ->from('ManagedFile f')
      ->leftJoin('f.FileDirectory d')
      ->where('d.member_id  = ?', $memberId);

    if (opFileManageConfig::isUsePrivate()
      && $memberId === sfContext::getInstance()->getUser()->getMemberId())
    {
      $q->andWhere('type <> ?', 'community');
    }
    else
    {
      $q->andWhere('type = ?', 'public');
    }

    return $q;
  }
}
