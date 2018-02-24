<?php

namespace Nerahikada;

use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use pocketmine\network\mcpe\protocol\SetEntityDataPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\UUID;

class FloatInfo extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		if(!file_exists($this->getDataFolder())) mkdir($this->getDataFolder());
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML,
			[
				"pos" => [
					"x" => 256,
					"y" => 5,
					"z" => 256
				],
				"time" => 5
			]
		);

		$pk = new AddPlayerPacket;
		$pk->uuid = UUID::fromRandom();
		$pk->username = "";
		$pk->entityRuntimeId = Entity::$entityCount++;
		$xyz = $config->get("pos");
		$pk->position = new Vector3((float) $xyz["x"], (float) $xyz["y"], (float) $xyz["z"]);
		$pk->item = Item::get(0);
		$flags = (
			(1 << Entity::DATA_FLAG_CAN_SHOW_NAMETAG) |
			(1 << Entity::DATA_FLAG_ALWAYS_SHOW_NAMETAG) |
			(1 << Entity::DATA_FLAG_IMMOBILE)
		);
		$pk->metadata = [
			Entity::DATA_FLAGS => [Entity::DATA_TYPE_LONG, $flags],
			Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, ""],
			Entity::DATA_SCALE => [Entity::DATA_TYPE_FLOAT, 0]
		];
		$this->floatingText = $pk;

		$pk = new SetEntityDataPacket;
		$pk->entityRuntimeId = $this->floatingText->entityRuntimeId;
		$pk->metadata = $this->floatingText->metadata;
		$this->updateText = $pk;

		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this, "updateInfo"]), $config->get("time") * 20);
	}

	public function onJoin(PlayerJoinEvent $event){
		$event->getPlayer()->dataPacket($this->floatingText);
	}

	public function updateInfo(){
		$players = $this->getServer()->getOnlinePlayers();
		$text = "§eServerInfo§f\n".
				"§bサーバの接続人数: §6".count($players)."人\n".
				"§b現在時刻: §a".date('n月d日G時i分');
		$this->floatingText->metadata[Entity::DATA_NAMETAG][1] = $text;
		$this->updateText->metadata[Entity::DATA_NAMETAG][1] = $text;
		$this->getServer()->broadcastPacket($players, $this->updateText);
	}

}