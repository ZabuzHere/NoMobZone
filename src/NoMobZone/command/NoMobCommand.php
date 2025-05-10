<?php

namespace NoMobZone\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\command\utils\CommandException;
use pocketmine\plugin\PluginOwned;
use NoMobZone\Main;
use NoMobZone\zone\ZoneManager;

class NoMobCommand extends Command implements PluginOwned {

	public function __construct() {
		parent::__construct("nomob", "Set No-Mob Zone");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args): void {
		if (!$sender instanceof Player) {
			$sender->sendMessage("Use this command in-game.");
			return;
		}

		switch (strtolower($args[0] ?? "")) {
			case "pos1":
				ZoneManager::setPos($sender->getName(), 1, $sender->getPosition());
				$sender->sendMessage("Pos1 set.");
				break;

			case "pos2":
				ZoneManager::setPos($sender->getName(), 2, $sender->getPosition());
				$sender->sendMessage("Pos2 set.");
				break;

			case "end":
				if (ZoneManager::confirmZone($sender->getName())) {
					$sender->sendMessage("No-Mob Zone created!");
				} else {
					$sender->sendMessage("Set both pos1 and pos2 first.");
				}
				break;

			default:
				$sender->sendMessage("/nomob pos1 | pos2 | end");
		}
	}

	public function getOwningPlugin(): Main {
		return Main::$instance;
	}
}
