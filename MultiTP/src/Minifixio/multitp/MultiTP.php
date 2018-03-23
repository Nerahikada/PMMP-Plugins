<?php
/**
 * This plugin allows to set random positions and when a player touch a sponge block, he is teleport to a random positions.
 *  
 * The default teleporting block is the sponge block ( why ?  for fun !  :). But you can change it at line 108.
 *
 * You can follow me on Twitter ( @Minifixio ) and suscribe to my youtube channel : Minifixio.
 *
 * I do not think that you will read this notes in the code but you can leave a comment in PocketMine for my first plugin !
 */

namespace Minifixio\multitp;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\event\Listener;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\Server;

use pocketmine\tile\Tile;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\tile\Sign;

use Minifixio\multitp\utils\PluginUtils;

class MultiTP extends PluginBase implements Listener {
	
	public $positions = array();
	
	public $randomConfig;

	/**
	* @return Position a random position based on current position array
	*/
	public function getRandomLocation($worldName){
		
		$worldPositions = array();
		
		foreach ($this->positions as $position){
			if($position->getLevel()->getName() == $worldName){
				array_push($worldPositions, $position);
			}
		}
		if(count($worldPositions) == 0){
			return NULL;
		}
		$numPos = mt_rand(1, count($worldPositions));
		return $worldPositions[$numPos - 1];
	}
	
	/**
	 * Add a new position and save it in the positions.yml
	 * @param Position position to add
	 */
	public function addNewLocation(Position $location){
		array_push($this->positions, $location);
		$this->randomConfig->set(count($this->positions), [$location->getX(), $location->getY(), $location->getZ(), $location->getLevel()->getName()]);
		$this->randomConfig->save();
	}
	
    /**
     * @return boolean
     */
	public function getNumberOfPositions(){
		return count($this->positions);	
	}
	
	/**
	 * Plugin initialization
	 */
	public function onEnable(){
		//Load Plugin
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("[MultiTP] >> Load MultiTP plugin by Minifixio ...");
		
		//Create data folder (for positions.yml)
		@mkdir($this->getDataFolder());
		
		//Create and load the positions configuration file
		$this->randomConfig = new Config($this->getDataFolder()."positions.yml", Config::YAML, array());
		
		//Load positions
		$this->positions = $this->parsePositions($this->randomConfig->getAll());
	}
	
	/**
     * Create positions based on the positions.yml configuration file
	 */
	public function parsePositions(array $w) {
		$ret = [];
		$index = 0;
		foreach ($w as $n => $data) {
			$this->getServer()->loadLevel($data[3]);
			if(($level = $this->getServer()->getLevelByName($data[3])) === null) $this->getLogger()->error($data[3] . " is not loaded. Position " . $n . " is disabled.");
			else{
				$ret[$index] = new Position($data[0], $data[1], $data[2], $level);
			}
			$index++;
		}
		return $ret;
	}
	
	/**
     * Reset all positions
	 */
	public function resetPositions() {
		$keys = $this->randomConfig->getAll(true);
		foreach ($keys as $key){
			$this->randomConfig->remove($key);
		}
		$this->randomConfig->save();
		unset($this->positions);
		$this->positions = array();
	}
	
	public function playerBlockTouch(PlayerInteractEvent $event){
		
		//Check block's id (= 19) > sponge block
		if($event->getBlock()->getID() == 19){
			if(count($this->positions) == 0){
				
				//If there are no positions set :
				$event->getPlayer()->sendMessage("[MultiTP] Sorry, there is no teleport position yet set");
			}
			else{
				
				//Teleport sender to a random position
				$event->getPlayer()->teleport($this->getRandomLocation($event->getPlayer()->getLevel()->getName()));
				$event->getPlayer()->sendMessage("Teleporting...");
			}
		}
		else
		if($event->getBlock()->getID() == Item::SIGN_POST || $event->getBlock()->getID() == Block::SIGN_POST || $event->getBlock()->getID() == Block::WALL_SIGN){
			$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
			if(!($sign instanceof Sign)){
				return;
			}
			$sign = $sign->getText();
			if($sign[0]=='[MultiTP]'){
				if(empty($sign[1]) !== true){
					$worldName = $sign[1];
					$event->getPlayer()->sendMessage("[MultiTP] Teleportation to '".$worldName."'");
					if(Server::getInstance()->loadLevel($worldName)){
						$targetPosition = $this->getRandomLocation($worldName);
						if($targetPosition == NULL){
							$event->getPlayer()->sendMessage("[MultiTP] No random location found in '".$worldName."'. Teleporting to its spawn.");
							$event->getPlayer()->teleport(Server::getInstance()->getLevelByName($worldName)->getSafeSpawn());
						}
						else{
							$event->getPlayer()->teleport($targetPosition);
						}
					}else{
						$event->getPlayer()->sendMessage("[MultiTP] World '".$worldName."' doesn't exist.");
					}
				}
			}
		}
	}
	
/**
=+=+=+=+=+=+=+=

>>>>> COMMANDS

=+=+=+=+=+=+=+=
**/
	
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
		switch($command->getName()){
			
			//rtpset command to set a random spawn position
			case "mtpset":
				$this->addNewLocation($sender->getLocation());
				$sender->sendMessage("[MultiTP] A new teleportation target was added at your position !");
				$sender->sendMessage("[MultiTP] There are : " . $this->getNumberOfPositions() . " teleportation targets.");
				return true;
				
			//rtpreset command to reset all random spawn positions
			case "mtpreset":
				$this->resetPositions();
				$sender->sendMessage("[MultiTP] All random spawn positions have been removed!");
				return true;
				
			//rtpinfo to have all informations about the plugin :)
			case "mtpinfo":
				$sender->sendMessage("[MultiTP] This plugin was created by Minifixio. I've got a Youtube channel, you can subscribe :)");
				$sender->sendMessage("[MultiTP] Commands : /mtpset ( to set a random spawn position )  and  /mtpreset ( to reset all random spawn positions.");
				$sender->sendMessage("[MultiTP] The default teleporting block is the sponge block, but you can change this in the code of the plugin.");
				$sender->sendMessage("[MultiTP] Perhaps there will be an update to modify the block of teleportation.");
                return true;
				$sender->sendMessage("[MultiTP] If you have suggestions or bugs, please report this to me !");
				
			default:
				return false;
		}
	}	
}