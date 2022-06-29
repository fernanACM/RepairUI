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

namespace fernanACM\RepairUI\commands;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
# Lib - Commando
use CortexPE\Commando\BaseCommand;
# My files - SubCommands
use fernanACM\RepairUI\commands\subcommands\HelpSubCommand;
use fernanACM\RepairUI\commands\subcommands\RepairAllSubCommand;
use fernanACM\RepairUI\commands\subcommands\RepairHandSubCommand;
# My files
use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class RepairCommand extends BaseCommand{

	protected function prepare(): void{
        $this->setPermission(
        	"repairui.cmd.acm;" .
            "repairui.help.acm;" .
        	"repairui.repair.all;" .
        	"repairui.repair.hand" 
    );

        $this->registerSubCommand(new HelpSubCommand("help", "RepairUI command list by fernanACM", ["list"]));
        if(RP::getInstance()->config->getNested("Commands.all")){
            $this->registerSubCommand(new RepairAllSubCommand("all", "Repair items in your entire inventory", ["a"]));
        }
        if(RP::getInstance()->config->getNested("Commands.hand")){
            $this->registerSubCommand(new RepairHandSubCommand("hand", "Repair the items in your hand", ["h"]));
        }
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
    	if (!$sender instanceof Player) {
              $sender->sendMessage("Use this command in-game");
              return;
        }
        if($sender->hasPermission("repairui.cmd.acm")){
         	   RP::getInstance()->repairmenu->RepairMenu($sender);
               PluginUtils::PlaySound($sender, "random.pop2", 1, 4.5);
        }else{
            $prefix = RP::getInstance()->getMessage($sender, "Prefix");
        	$sender->sendMessage($prefix . RP::getInstance()->getMessage($sender, "Messages.no-permission"));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
        }
    }
}