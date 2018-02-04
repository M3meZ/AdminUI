<?php

namespace AdminUI;

#Server Player
use pocketmine\{Server, Player};
#Base
use pocketmine\plugin\PluginBase;
#Event
use pocketmine\event\Listener;
#TextFormat
use pocketmine\utils\TextFormat;
#Effect
use pocketmine\entity\Effect;
#COMMAND
use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};
#PACKET
use pocketmine\event\server\DataPacketReceiveEvent;
#API
use jojoe77777\FormAPI;

class Main extends PluginBase implements Listener {
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label,array $args): bool{
		$player = $sender->getPlayer();
		switch($cmd->getName()){
			case "admin":
			$this->mainFrom($player);
			break;		
		}
		return true;
	}
	
	public function mainFrom($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $event, array $data){
		$player = $event->getPlayer();
		$result = $data[0];
		if($result === null){
		}
		switch($result){							
			case 0:
			break;
			case 1:
			$this->banUI($player);
			break;
			case 2:
			$this->kickUI($player);
			break;
			}					
		});					
		$form->setTitle(TextFormat::BLUE . "--= " . TextFormat::RED . "AdminUI" . TextFormat::BLUE . " =--");
		$form->setContent("");
		$form->addButton(TextFormat::BLACK . "BACK");
		$form->addButton(TextFormat::RED . "BAN");
		$form->addButton(TextFormat::RED . "KICK");
		//$form->addButton(TextFormat::RED . "INFO");
		$form->sendToPlayer($player);
	}
	
	public function banUI($player){ 
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI"); 
		$form = $api->createCustomForm(function (Player $event, array $data){
		$player = $event->getPlayer();
		$result = $data[0];
		if($result != null){
		$this->targetName = $result;
		$this->reason = $data[1];
		$this->getServer()->dispatchCommand(new ConsoleCommandSender, "ban " . $this->targetName . " " . $this->reason);
		}
		});
		$form->setTitle(TextFormat::BOLD . "BAN PLAYER");
		$form->addInput("PLAYER NAME");
		$form->addInput("REASON");
		$form->sendToPlayer($player);
	}
	
	public function kickUI($player){ 
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI"); 
		$form = $api->createCustomForm(function (Player $event, array $data){
		$player = $event->getPlayer();
		$result = $data[0];
		if($result != null){
		$this->targetName = $result;
		$this->reason = $data[1];
		$this->getServer()->dispatchCommand(new ConsoleCommandSender, "kick " . $this->targetName . " " . $this->reason);
		}
		});
		$form->setTitle(TextFormat::BOLD . "KICK PLAYER");
		$form->addInput("PLAYER NAME");
		$form->addInput("REASON");
		$form->sendToPlayer($player);
	}
}
