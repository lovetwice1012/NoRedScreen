<?php

namespace FastRespawn;

use pocketmine\utils\TextFormat as Color;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerMoveEvent;

class Main extends PluginBase implements Listener {

    private $players = [];

    public function onMove(PlayerMoveEvent $event) {
        $player = $event->getPlayer();
        $playerN = $player->getName();
        if ($event->getPlayer()->getY() < -5) {
            $event->getPlayer()->teleport($event->getPlayer()->getLevel()->getSafeSpawn());
            $player->setHealth(20);
            $player->setFood(20);
            foreach ($this->getServer()->getOnlinePlayers() as $players) {
                $void_msg = "§4".$playerN."§5が奈落におちました！足元には気をつけてください…";
                $players->sendMessage($void_msg);
            }
        }
    }
        public  function onDamage(EntityDamageByEntityEvent $event) {    
                if ($event->getEntity() instanceof Player && $event->getDamager() instanceof Player) {
                    $player = $event->getEntity();
                    $killer = $event->getDamager();
                    $playerN = $player->getName();
                    $killerN = $killer->getName();
                    if ($event->getBaseDamage() >= $event->getEntity()->getHealth()) {
                        $event->setCancelled();
                        $player->setHealth(20);
                        $player->setFood(20);
                        $player->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
			$this->getServer()->getPluginManager()->callEvent(new PlayerDeathEvent($player, [], ""));
                        foreach ($this->getServer()->getOnlinePlayers() as $players) {
                            $killer_msg = "§4".$killerN."§5が§4".$playerN."§5を殺害しました…";
                            $players->sendMessage($killer_msg);
			}
		    }      
               }
	}
 }
