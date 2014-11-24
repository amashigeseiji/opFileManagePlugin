<?php
/**
 * FileDirectoryQuery
 */
class FileDirectoryQuery extends Doctrine_Query
{
  static public function create($conn = null, $class = null)
  {
    return parent::create($conn, 'FileDirectoryQuery')
      ->from('FileDirectory');
  }

  public function addMemberId($memberId)
  {
    return $this->andWhere('member_id = ?', $memberId);
  }

  public function addOrderBy($orderBy = null)
  {
    return $this->orderBy($orderBy ? $orderBy : 'created_at DESC');
  }

  public function addType($types)
  {
    # if type is empty, return empty collection
    if (empty($types))
    {
      return $this->andWhere('type IS NULL');
    }

    return $this->andWhereIn('type', $types);
  }

  public static function getListQueryByMemberId($memberId, $types)
  {
    return self::create()
      ->addMemberId($memberId)
      ->addOrderBy()
      ->addType($types);
  }

  public static function getListQueryByCommunityId($communityId)
  {
    $directoryIds = Doctrine::getTable('DirectoryConfig')
      ->getDirectoryIdsByCommunityId($communityId);

    return Doctrine_Query::create()
      ->from('FileDirectory')
      ->whereIn('id', $directoryIds);
  }
}
