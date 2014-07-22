<?php
class opDirectoryConfig
{
  public function __construct($directoryId)
  {
    $this->directoryId = $directoryId;
    $this->baseQuery = Doctrine::getTable('DirectoryConfig')->getDirectoryConfigQuery($directoryId);
  }

  public function create($communityId)
  {
    $config = new DirectoryConfig();

    return $config->create($this->directoryId, $communityId);
  }

  public function has($column)
  {
    $config = $this->baseQuery
      ->andWhere($column.' <> ""')
      ->fetchOne();

    return $config ? true : false;
  }

  public function getCommunityId()
  {
    if ($config = $this->getDirectoryCommunityConfig())
    {
      return $config->getCommunityId();
    }

    return null;
  }

  public function updateCommunityId($communityId)
  {
    if ($config = $this->getDirectoryCommunityConfig())
    {
      return $config->updateCommunityId($communityId);
    }

    return null;
  }

  public function getCommunity()
  {
    if ($config = $this->getDirectoryCommunityConfig())
    {
      return $config->getCommunity();
    }

    return null;
  }

  public function getCommunityConfig($key)
  {
    if ($config = $this->getDirectoryCommunityConfig())
    {
      return $config->getCommunity()->getConfig($key);
    }

    return null;
  }

  private function getDirectoryCommunityConfig()
  {
    return $this->baseQuery
      ->andWhere('community_id <> ""')
      ->fetchOne();
  }
}
