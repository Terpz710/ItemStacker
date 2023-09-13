<?php

namespace david\itemStacker;

use pocketmine\entity\object\ItemEntity;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\Listener;

class EventListener implements Listener {

    public function __construct(Loader $plugin) 
    }

    public function onEntitySpawn(EntitySpawnEvent $event) {
        $entity = $event->getEntity();
        if (!$entity instanceof ItemEntity) {
            return;
        }
        
        $position = $entity->getPosition();
        $world = $position->getWorld();
        $entities = $world->getNearbyEntities($entity->getBoundingBox()->expandedCopy(5, 5, 5));

        if (empty($entities)) {
            return;
        }

        $originalItem = $entity->getItem();
        foreach ($entities as $e) {
            if ($e instanceof ItemEntity && $entity !== $e) {
                $itemE = $e->getItem();
                if ($itemE->equals($originalItem)) {
                    $e->flagForDespawn();
                    $originalItem->setCount($originalItem->getCount() + $itemE->getCount());
                }
            }
        }
    }
}
