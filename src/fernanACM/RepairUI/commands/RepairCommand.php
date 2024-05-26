<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\commands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;
# Lib - Commando
use CortexPE\Commando\BaseCommand;
# My files - SubCommands
use fernanACM\RepairUI\commands\subcommands\HelpSubCommand;
use fernanACM\RepairUI\commands\subcommands\LoreSubCommand;
use fernanACM\RepairUI\commands\subcommands\RenameSubCommand;
use fernanACM\RepairUI\commands\subcommands\RepairAllSubCommand;
use fernanACM\RepairUI\commands\subcommands\RepairHandSubCommand;
# My files
use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\permissions\Perms;

class RepairCommand extends BaseCommand{

    public function __construct(){
        parent::__construct(RP::getInstance(), "repairui", "Open RepairUI by fernanACM", ["rp", "repair", "fix", "sipe"]);
        $this->setPermission(Perms::CMD);
    }

    /**
     * @return void
     */
	protected function prepare(): void{
        $this->registerSubCommand(new HelpSubCommand);
        if(boolval(RP::getInstance()->config->getNested("Settings.Commands.all", true))){
            $this->registerSubCommand(new RepairAllSubCommand);
        }
        if(boolval(RP::getInstance()->config->getNested("Settings.Commands.hand", true))){
            $this->registerSubCommand(new RepairHandSubCommand);
        }
        if(boolval(RP::getInstance()->config->getNested("Settings.Commands.lore", true))){
            $this->registerSubCommand(new LoreSubCommand);
        }
        if(boolval(RP::getInstance()->config->getNested("Settings.Commands.rename", true))){
            $this->registerSubCommand(new RenameSubCommand);
        }
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
        if(!$sender->hasPermission(Perms::CMD)){
            $sender->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        RP::getInstance()->getFormManager()->getMenu()->open($sender);
        PluginUtils::PlaySound($sender, "random.pop2", 1, 1);
    }
}