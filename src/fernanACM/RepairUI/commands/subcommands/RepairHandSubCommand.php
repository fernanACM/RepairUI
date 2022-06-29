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

namespace fernanACM\RepairUI\commands\subcommands;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\item\ToolTier;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\Tool;
# Lib - Commando
use CortexPE\Commando\BaseSubCommand;
# My files
use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class RepairHandSubCommand extends BaseSubCommand{

	protected function prepare(): void{
        $this->setPermission("repairui.repair.hand");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
    	if(!$sender instanceof Player){
              $sender->sendMessage("Use this command in-game");
              return;
        }
        if($sender->hasPermission("repairui.repair.hand")){
            $item = $sender->getInventory()->getItemInHand();
            if(($item instanceof Tool) or ($item instanceof Armor)){
                if($item->getMeta() !== 0){
                    $item->setDamage(0);
                    $sender->getInventory()->setItemInHand($item);
                    $prefix = RP::getInstance()->getMessage($sender, "Prefix");
                    $sender->sendMessage($prefix . RP::getInstance()->getMessage($sender, "Messages.repairhand-success"));
                    PluginUtils::PlaySound($sender, "random.anvil_use", 1, 1);     
                }else{
                    $prefix = RP::getInstance()->getMessage($sender, "Prefix");
                    $sender->sendMessage($prefix . RP::getInstance()->getMessage($sender, "Messages.no-damage"));
                    PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
                }
            }else{
                $prefix = RP::getInstance()->getMessage($sender, "Prefix");
                $sender->sendMessage($prefix . RP::getInstance()->getMessage($sender, "Messages.no-item"));
                PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            }
        }else{
            $prefix = RP::getInstance()->getMessage($sender, "Prefix");
        	$sender->sendMessage($prefix . RP::getInstance()->getMessage($sender, "Messages.no-permission"));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
        }
    }
}