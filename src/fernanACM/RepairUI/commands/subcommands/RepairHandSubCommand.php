<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\commands\subcommands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;
# Lib - Commando
use CortexPE\Commando\BaseSubCommand;
# My files
use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\permissions\Perms;
use fernanACM\RepairUI\manager\RepairManager;

class RepairHandSubCommand extends BaseSubCommand{

    public function __construct(){
        parent::__construct("hand", "", []);
        $this->setPermission(Perms::REPAIR_HAND);
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
        if(!$sender->hasPermission(Perms::REPAIR_HAND)){
            $sender->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        RepairManager::getInstance()->sendRepairedItem($sender);
    }
}