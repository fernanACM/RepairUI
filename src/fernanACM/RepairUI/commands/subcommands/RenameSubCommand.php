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
use CortexPE\Commando\args\TextArgument;
# My files
use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PermissionsUtils;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;
use fernanACM\RepairUI\manager\RepairManager;

class RenameSubCommand extends BaseSubCommand{

    public function __construct(){
        parent::__construct("rename", "", []);
        $this->setPermission(PermissionsUtils::RENAME_CMD);
    }

    /**
     * @return void
     */
	protected function prepare(): void{
        $this->registerArgument(0, new TextArgument("text", true));
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
        if(!$sender->hasPermission(PermissionsUtils::RENAME_CMD)){
            $sender->sendMessage(RP::Prefix(). WordUtils::NO_PERMISSION);
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        if(!isset($args["text"])){
            $sender->sendMessage(RP::Prefix(). "§c/repairui rename <name>");
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        $item = $sender->getInventory()->getItemInHand();
        if($item->isNull()){
            $sender->sendMessage(RP::Prefix() . RP::getMessage($sender, WordUtils::NO_ITEM));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        RepairManager::getInstance()->sendRenamedItem($sender, $item, RepairManager::RENAME_MODE, $args["text"]);
    }
}