<?php

namespace NoMobZone;

use pocketmine\plugin\PluginBase;
use NoMobZone\zone\ZoneManager;
use NoMobZone\listener\EntitySpawnListener;
use NoMobZone\command\NoMobCommand;

class Main extends PluginBase {

	public static Main $instance;

	protected function onEnable(): void {
		self::$instance = $this;
		$this->getServer()->getPluginManager()->registerEvents(new EntitySpawnListener(), $this);
		$this->getServer()->getCommandMap()->register("nomob", new NoMobCommand());

		@mkdir($this->getDataFolder());
		ZoneManager::init($this->getDataFolder() . "zones.json");
	}
}
