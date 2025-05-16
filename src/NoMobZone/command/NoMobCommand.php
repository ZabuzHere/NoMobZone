<?php

namespace NoMobZone\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use NoMobZone\Main;
use NoMobZone\zone\ZoneManager;

class NoMobCommand extends Command implements PluginOwned {

    public function __construct() {
        parent::__construct("nomob", "Set No-Mob Zone");
        $this->setPermission("nomobzone.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Use this command in the game.");
            return;
        }

        if (!$this->testPermission($sender)) {
            $sender->sendMessage("You do not have permission to run this command.");
            return;
        }

        switch (strtolower($args[0] ?? "")) {
            case "pos1":
                ZoneManager::setPos($sender->getName(), 1, $sender->getPosition());
                $sender->sendMessage("Post1 is marked.");
                break;

            case "pos2":
                ZoneManager::setPos($sender->getName(), 2, $sender->getPosition());
                $sender->sendMessage("Post2 is marked.");
                break;

            case "end":
                if (ZoneManager::confirmZone($sender->getName())) {
                    $sender->sendMessage("No-Mob Zone successfully created!");
                } else {
                    $sender->sendMessage("You have to set pos1 and pos2 first.");
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
