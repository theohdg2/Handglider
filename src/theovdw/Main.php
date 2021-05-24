<?php

namespace theovdw;

use pocketmine\entity\Damageable;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Main extends PluginBase implements Listener
{
    public function onEnable(): void
    {
     $this->getLogger()->info("§1 plugin hanglider on");
     $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }

    public function antibug(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if(!empty($player->getEffect(24))){
            $player->removeEffect(24);
        }
    }

    public function handglider(PlayerItemHeldEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();

        if($item->getId() == 341){
          $player->addEffect(new EffectInstance(Effect::getEffect(24),214748364,-3,false));
        }else{
            if(!empty($player->getEffect(24))){
             $player->removeEffect(24);
            }
        }
    }
    public function isInHanglider(EntityDamageEvent $event){
        $qui = $event->getEntity();
        $damage = $event->getCause();
        if($damage == EntityDamageEvent::CAUSE_FALL) {
            if ($qui instanceof Player) {
                if ($qui->getInventory()->getItemInHand()->getId() == 341) {
                    $event->setCancelled(true);
                }
            }
        }
    }
}