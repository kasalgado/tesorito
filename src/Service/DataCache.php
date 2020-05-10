<?php declare (strict_types=1);

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DataCache
{
    private $cache;
    private $serializer;
    
    public function __construct(AdapterInterface $cache, SerializerInterface $serializer)
    {
        $this->cache = $cache;
        $this->serializer = $serializer;
    }
    
    public function get($data, string $widget)
    {
        $entities = [];
        
        foreach ($data as $entity) {
            $entities[] = $this->serializer->serialize($entity, 'json');
        }
        
        $item = $this->cache->getItem($widget.'_'.md5(json_encode($entities)));
        
        if (!$item->isHit()) {
            $item->set($data);
            $this->cache->save($item);
        }
        
        return $item->get();
    }
}
