<?php

namespace NoMobZone\listener;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntitySpawnEvent;
use NoMobZone\zone\ZoneManager;
use tgwaste\Mobs\Entities\MobsEntity;

class EntitySpawnListener implements Listener {

	public function onEntitySpawn(EntitySpawnEvent $event): void {
		$entity = $event->getEntity();
		if ($entity instanceof MobsEntity && ZoneManager::isInNoMobZone($entity->getPosition())) {
			$event->cancel();
		}
	}
}
