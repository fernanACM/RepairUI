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

namespace fernanACM\RepairUI;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
# Blocks
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
# Items
use pocketmine\item\ToolTier;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\Tool;
# Libs
use Vecnavium\FormsUI\FormsUI;

use davidglitch04\libEco\libEco;

use muqsit\simplepackethandler\SimplePacketHandler;

use CortexPE\Commando\PacketHooker;
use CortexPE\Commando\BaseCommand;
# My flies
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\events\block\Anvil;
use fernanACM\RepairUI\events\EventListener;

use fernanACM\RepairUI\forms\RepairMenu;
use fernanACM\RepairUI\forms\subforms\RepairForm;
use fernanACM\RepairUI\forms\subforms\LoreForm;
use fernanACM\RepairUI\forms\subforms\RenameForm;
use fernanACM\RepairUI\forms\subforms\CostForm;

use fernanACM\RepairUI\commands\RepairCommand;

class RP extends PluginBase{

    public static $instance;
	public Config $config;
	public Config $messages;

	public function onEnable(): void{
		self::$instance = $this;
        $this->saveDefaultConfig();
		$this->saveResource("config.yml");
		$this->saveResource("messages.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml");
		$this->messages = new Config($this->getDataFolder() . "messages.yml");
		$this->loadEvents();
		foreach([
		       "FormsUI" => FormsUI::class,
		       "LibEco" => libEco::class,
               "Commando" => BaseCommand::class,
               "SimplePacketHandler" => SimplePacketHandler::class
            ] as $virion => $class
        ) {
            if (!class_exists($class)) {
                $this->getLogger()->error($virion . " virion not found. Please download RepairUI from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }
        # Commando
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
	}

	public function loadEvents(){
		$this->repairmenu = new RepairMenu($this);
		$this->repair = new RepairForm($this);
		$this->lore = new LoreForm($this);
		$this->rename = new RenameForm($this);
		$this->cost = new CostForm($this);

		# Blocks
        $block = BlockFactory::getInstance();
		$blockID = new BlockBreakInfo(5.0, BlockToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel(), 6000.0);
        $block->register(new Anvil(new BlockIdentifier(BlockLegacyIds::ANVIL, 0), 'Anvil', $blockID), true);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->useAnvil = $this->config->getNested("Use.Anvil");

        # Commands
        $this->getServer()->getCommandMap()->register("repairui", new RepairCommand($this, "repairui", "Open RepairUI by fernanACM", ["rp", "repair", "fix", "sipe"]));       
	}
    # Repair Utils
	public function RepairAll(Item $item): bool{
		return $item instanceof Tool || $item instanceof Armor;
	}

	public function getMessage(Player $player, string $key){
        return PluginUtils::codeUtil($player, $this->messages->getNested($key, $key));
    }
    
    public static function getInstance(): RP{
        return self::$instance;
    }
}