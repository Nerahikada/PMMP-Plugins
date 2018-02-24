<?php

namespace Nerahikada;

use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\Server;

class DisplayTask extends Task{

	public function __construct(Player $player, string $function, string $message, int $duration){
		$this->callable = [$player, $function];
		$this->message = $message;
		$this->duration = $duration;
		$this->current = 0;
	}

	public function onRun(int $currentTick){
		$callable = $this->callable;
		$callable($this->message);

		$this->current++;
		if($this->current >= $this->duration){
			Server::getInstance()->getScheduler()->cancelTask($this->getTaskId());
		}
	}

}