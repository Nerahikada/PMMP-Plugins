<?php

namespace Nerahikada;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class PopupDisplayer extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		if(!file_exists($this->getDataFolder())) mkdir($this->getDataFolder());
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
			"message" => "Welcome to our Server!",
			"type" => "tip",
			"duration" => 10
		]);

		$this->message = $config->get("message");
		$this->duration = ((int) $config->get("duration")) * 2;

		$type = strtolower($config->get("type"));
		if($type === "tip"){
			$this->type = "sendTip";
		}else if($type === "popup"){
			$this->type = "sendPopup";
		}else{
			$this->getLogger()->error("無効なタイプです: " . $config->get("type"));
			$this->getLogger()->error("タイプには tip もしくは popup を使用してください");
			$this->getLogger()->info("tip を使用します");
			$this->type = "sendTip";
		}
	}

	public function onJoin(PlayerJoinEvent $event){
		$task = new DisplayTask($event->getPlayer(), $this->type, $this->message, $this->duration);
		$this->getServer()->getScheduler()->scheduleRepeatingTask($task, 10);
	}

}