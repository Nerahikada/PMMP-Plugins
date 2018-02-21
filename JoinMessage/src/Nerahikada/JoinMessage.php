<?php

namespace Nerahikada;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;

class JoinMessage extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		if(!file_exists($this->getDataFolder())) mkdir($this->getDataFolder());
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML,
			["message" => [
				"JoinMessage  by ねらひかだ",
				"メッセージを変更するには、config.ymlを変更してください。",
				"このメッセージはいくらでも増やすことが可能です。"
			]]
		);
		$this->joinMessage = $config->get("message");
	}

	public function onJoin(PlayerJoinEvent $event){
		$task = new SendJoinMessageTask($this, $event->getPlayer());
		$this->getServer()->getScheduler()->scheduleDelayedTask($task, 1);
	}

}


class SendJoinMessageTask extends PluginTask{

	public function __construct(PluginBase $owner, $player){
		parent::__construct($owner);
		$this->player = $player;
	}

	public function onRun(int $currentTick){
		foreach($this->getOwner()->joinMessage as $message){
			$this->player->sendMessage($message);
		}
	}

}