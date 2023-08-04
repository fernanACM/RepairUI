<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\block\VanillaBlocks;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class EventListener implements Listener{
    
    /**
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function onInteract(PlayerInteractEvent $event): void{
    	$player = $event->getPlayer();
    	$block = $event->getBlock();
        if(RP::getInstance()->config->getNested("Settings.Use.anvil")){
            if($block->getTypeId() === VanillaBlocks::ANVIL()->getTypeId()){
                $event->cancel();
    			RP::getInstance()->getRepairMenu()->getRepairMenu($player);
                PluginUtils::PlaySound($player, "random.pop", 1, 1);
            }
        }
    }
}