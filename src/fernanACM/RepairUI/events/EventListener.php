<?php

#  ____                           _          _   _   ___ 
# |  _ \    ___   _ __     __ _  (_)  _ __  | | | | |_ _|
# | |_) |  / _ \ | '_ \   / _` | | | | '__| | | | |  | | 
# |  _ <  |  __/ | |_) | | (_| | | | | |    | |_| |  | | 
# |_| \_\  \___| | .__/   \__,_| |_| |_|     \___/  |___|
#                |_|                                     
#   Copyright [2022-2022] [fernanACM]

#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at

#       http://www.apache.org/licenses/LICENSE-2.0

#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.

namespace fernanACM\RepairUI\events;

use pocketmine\player\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\block\Anvil;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class EventListener implements Listener{
    
    public function onInteract(PlayerInteractEvent $event){
		if($event->isCancelled()) return false;	
    	$player = $event->getPlayer();
    	$block = $event->getBlock();
        if(RP::getInstance()->useAnvil){
            if($block instanceof Anvil){
    			$event->cancel();
    			RP::getInstance()->repairmenu->RepairMenu($player);
                PluginUtils::PlaySound($player, "random.pop", 1, 1);
            }
        }
    	return true;
    }
}