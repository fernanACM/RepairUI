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
class HelpSubCommand extends BaseSubCommand{
    
    public function __construct(){
        parent::__construct("help", "", ["?"]);
        $this->setPermission(Perms::HELP);
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
        if(!$sender->hasPermission(Perms::HELP)){
            $sender->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        $sender->sendMessage("§l§e»RepairUI«");
        $sender->sendMessage("§7» /repairui - Open RepairUI");
        $sender->sendMessage("§7» /repairui help - Command list");
        $sender->sendMessage("§7» /repairui all - Repair all items");
        $sender->sendMessage("§7» /repairui hand - Repair the items in your hand");
        $sender->sendMessage("§7» /repairui rename <name> - Rename the item in your hand");
        $sender->sendMessage("§7» /repairui lore <lore> - Lore the item in your hand");
        PluginUtils::PlaySound($sender, "random.pop2", 1, 1);
    }
}