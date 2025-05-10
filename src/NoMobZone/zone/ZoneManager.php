<?php

namespace NoMobZone\zone;

use pocketmine\math\Vector3;
use pocketmine\world\Position;

class ZoneManager {
	private static array $zones = [];
	private static string $filePath;

	public static function init(string $filePath): void {
		self::$filePath = $filePath;
		if (file_exists($filePath)) {
			self::$zones = json_decode(file_get_contents($filePath), true) ?? [];
		}
	}

	public static function setPos(string $playerName, int $pos, Position $position): void {
		self::$zones[$playerName]["pos$pos"] = [
			"x" => $position->getX(),
			"y" => $position->getY(),
			"z" => $position->getZ(),
			"world" => $position->getWorld()->getFolderName()
		];
	}

	public static function confirmZone(string $playerName): bool {
		if (!isset(self::$zones[$playerName]["pos1"], self::$zones[$playerName]["pos2"])) return false;

		$zone = self::$zones[$playerName];
		self::$zones["areas"][] = [
			"pos1" => $zone["pos1"],
			"pos2" => $zone["pos2"]
		];
		unset(self::$zones[$playerName]);
		self::save();
		return true;
	}

	private static function save(): void {
		file_put_contents(self::$filePath, json_encode(self::$zones));
	}

	public static function isInNoMobZone(Position $pos): bool {
		foreach (self::$zones["areas"] ?? [] as $zone) {
			if ($pos->getWorld()->getFolderName() !== $zone["pos1"]["world"]) continue;

			$x1 = min($zone["pos1"]["x"], $zone["pos2"]["x"]);
			$y1 = min($zone["pos1"]["y"], $zone["pos2"]["y"]);
			$z1 = min($zone["pos1"]["z"], $zone["pos2"]["z"]);
			$x2 = max($zone["pos1"]["x"], $zone["pos2"]["x"]);
			$y2 = max($zone["pos1"]["y"], $zone["pos2"]["y"]);
			$z2 = max($zone["pos1"]["z"], $zone["pos2"]["z"]);

			if ($pos->getX() >= $x1 && $pos->getX() <= $x2 &&
				$pos->getY() >= $y1 && $pos->getY() <= $y2 &&
				$pos->getZ() >= $z1 && $pos->getZ() <= $z2) {
				return true;
			}
		}
		return false;
	}
}
