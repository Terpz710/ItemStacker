<?php

namespace david\itemStacker;

use pocketmine\entity\object\ItemEntity;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\Listener;

class EventListener implements Listener {

    /** @var Loader */
    private $plugin;

    /**
     * EventListener constructor.
     *
     * @param Loader $plugin
     */
    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param EntitySpawnEvent $event
     */
    public function onEntitySpawn(EntitySpawnEvent $event) {
        $entity = $event->getEntity();
        if ($entity instanceof ItemEntity) {
            $position = $entity->getPosition();
            $world = $position->getWorld();
            $entities = $world->getNearbyEntities($entity->getBoundingBox()->expandedCopy(5, 5, 5));
            if (empty($entities)) {
                return;
            }
            $originalItem = $entity->getItem();
            foreach ($entities as $e) {
                if ($e instanceof ItemEntity && $entity->getId() !== $e->getId()) {
                    $item = $e->getItem();
                    if ($item->getId() === $originalItem->getId()) {
                        $e->flagForDespawn();
                        $entity->getItem()->setCount($originalItem->getCount() + $item->getCount());
                    }
                }
            }
        }
    }
}
