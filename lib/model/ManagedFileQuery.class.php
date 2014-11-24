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
      ->from('ManagedFile f');
  }

  public function addDirectoryId($directoryId)
  {
    return $this->andWhere('f.directory_id = ?', $directoryId);
  }

  public function whereInDirectoryIds($directoryIds)
  {
    return $this->andWhereIn('f.directory_id', $directoryIds);
  }

  public function addMemberId($memberId)
  {
    return $this->andWhere('f.member_id = ?', $memberId);
  }

  public function addOrderBy($orderBy = null)
  {
    return $this->orderBy($orderBy ? $orderBy : 'f.created_at DESC');
  }

  public function addDirectoryType($types)
  {
    if ($types)
    {
      return $this->andWhereIn('d.type', $types);
    }
    else
    {
      return $this->andWhere('d.type IS NULL');
    }
  }

  public function addLeftJoinDirectory($alias = 'd')
  {
    return $this->leftJoin("f.FileDirectory $alias");
  }

  private function addSearchQuery($searchParameter)
  {
    foreach ($searchParameter as $key => $val)
    {
      if ($val)
      {
        if ($key === 'name' || $key === 'note')
        {
          $this->andWhere("f.$key LIKE ?", "%$val%");
        }
        elseif ($key === 'member_id')
        {
          $this->addMemberId($val);
        }
      }
    }

    return $this;
  }

  public static function getJoinedDirectoryQuery($alias = 'd')
  {
    return self::create()->addLeftJoinDirectory($alias);
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

    return self::create()->whereInDirectoryIds($directoryIds);
  }

  public static function getMemberFileListQuery($memberId)
  {
    $q = self::getJoinedDirectoryQuery()
      ->addOrderBy()
      ->where('d.member_id = ?', $memberId);

    $allowedTypes = array('public');
    if ($memberId === sfContext::getInstance()->getUser()->getMemberId())
    {
      $allowedTypes[] = 'private';
    }

    return $q->addDirectoryType(Doctrine::getTable('FileDirectory')->getTypes($allowedTypes));
  }

  public static function getPublicFileListQuery($searchParameter = null)
  {
    $q = self::getJoinedDirectoryQuery()
      ->addOrderBy();

    $q->addDirectoryType(Doctrine::getTable('FileDirectory')->getTypes(array('public')));

    if ($searchParameter)
    {
      $q->addSearchQuery($searchParameter);
    }

    return $q;
  }
}
