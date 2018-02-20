<?php

namespace philipshilling\alwaysspawn;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\level\Position;
				
class Loader extends PluginBase implements Listener {

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getLogger()->info("AlwaysSpawn Enabled!");
	}

	public function onPlayerLogin(PlayerLoginEvent $event) {
		$player = $event->getPlayer();
		$pos = $this->getServer()->getDefaultLevel()->getSafeSpawn();
		$player->setLevel($pos->level);
		$player->teleport(new Position($pos->x, $pos->y, $pos->z, $pos->level));
	}

	public function onDisable() {
		$this->getServer()->getLogger()->info("AlwaysSpawn is no longer enabled! Did the server stop?");
	}

}