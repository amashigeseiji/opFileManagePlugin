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

  /*
   * static functions
   */

  public static function getOrderedQuery()
  {
    return self::create()->addOrderBy();
  }

  public static function getListQueryByMemberId($memberId, $types)
  {
    return self::getOrderedQuery()
      ->addMemberId($memberId)
      ->addType($types);
  }

  public static function getListQueryByCommunityId($communityId)
  {
    $directoryIds = Doctrine::getTable('DirectoryConfig')
      ->getDirectoryIdsByCommunityId($communityId);

    return self::getOrderedQuery()->whereIn('id', $directoryIds);
  }
}
