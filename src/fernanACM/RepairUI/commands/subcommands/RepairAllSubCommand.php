<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI\commands\subcommands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;
# Lib - Commando
use CortexPE\Commando\BaseSubCommand;
# My files
use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PermissionsUtils;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;
use fernanACM\RepairUI\manager\RepairManager;

class RepairAllSubCommand extends BaseSubCommand{

    public function __construct(){
        parent::__construct("all", "", []);
        $this->setPermission(PermissionsUtils::REPAIR_ALL);
    }

    /**
     * @return void
     */
	protected function prepare(): void{
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
    	if(!$sender instanceof Player){
            $sender->sendMessage("Use this command in-game");
            return;
        }
        if(!$sender->hasPermission(PermissionsUtils::REPAIR_ALL)){
            $sender->sendMessage(RP::Prefix(). WordUtils::NO_PERMISSION);
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        RepairManager::getInstance()->sendInventoryAllRepaired($sender);
    }
}