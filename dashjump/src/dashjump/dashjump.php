<?php

namespace dashjump;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDamageEvent;
//use pocketmine\scheduler\CallbackTask;

class dashjump extends PluginBase implements Listener{

	public function onEnable(){
		if(!file_exists($this->getDataFolder())) @mkdir($this->getDataFolder(), 0755, true);
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, ["block" => 133]);
		$this->djb = (int) $this->config->get("block");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->users = [];
		$this->temporalVector = new Vector3();
	}

	public function onDisable(){
		$this->config->save();
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
		if($label === "djb"){
			if(!isset($args[0]) || empty($args[0]) || !ctype_digit($args[0])) return false;
			$this->config->set("block", $args[0]);
			$this->config->save();
			$this->djb = (int) $args[0];
			$sender->sendMessage("id".$args[0]."にセット完了！");
			return true;
		}
		return false;
	}

	public function onMove(PlayerMoveEvent $event){
		$p = $event->getPlayer();
		$block = $p->getLevel()->getBlockAt($p->x, $p->y - 1, $p->z, true, false);
		if($block->getId() === $this->djb){
			$pos = $p->getDirectionVector();
			$this->temporalVector->setComponents($pos->x * 1.1, 0.5, $pos->z * 1.1);
			$p->setMotion($this->temporalVector);
			if(empty($this->users[$event->getPlayer()->getName()])){
				$this->users[$event->getPlayer()->getName()] = 1;
				//$this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this,"ActiveDamage" ], [$event->getPlayer()->getName()]),20*4);
			}
		}
	}

	/*
	public function onDamage(EntityDamageEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player){
			if(!empty($this->users[$entity->getName()])) return $event->setCancelled();
		}
	}
	*/

	/*
	public function ActiveDamage($name){
		unset($this->users[$name]);
	}
	*/

}