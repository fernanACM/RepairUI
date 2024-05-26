<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\block\VanillaBlocks;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class Event implements Listener{
    
    /**
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function onInteract(PlayerInteractEvent $event): void{
    	$player = $event->getPlayer();
    	$block = $event->getBlock();
        if(boolval(RP::getInstance()->config->getNested("Settings.Use.anvil", true))){
            if($block->hasSameTypeId(VanillaBlocks::ANVIL()) and $event->getAction() === $event::RIGHT_CLICK_BLOCK){
                $event->cancel();
    			RP::getInstance()->getFormManager()->getMenu()->open($player);
                PluginUtils::PlaySound($player, "random.pop", 1, 1);
            }
        }
    }
}