<?php

namespace philipshilling\alwaysspawn;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
				
class Loader extends PluginBase implements Listener {

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onPlayerLogin(PlayerLoginEvent $event) {
		$player = $event->getPlayer();
		$pos = $this->getServer()->getDefaultLevel()->getSafeSpawn();
		$player->setLevel($pos->level);
		$player->teleport($pos);
	}

}