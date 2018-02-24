<?php

namespace Nerahikada;

use pocketmine\scheduler\Task;

class CallbackTask extends Task{

	protected $callable;
	protected $args;

	public function __construct(callable $callable, array $args = []){
		$this->callable = $callable;
		$this->args = $args;
	}

	public function getCallable() : callable{
		return $this->callable;
	}

	public function onRun(int $currentTick){
		$callable = $this->callable;
		$args = $this->args;
		$callable(...$args);
	}

}