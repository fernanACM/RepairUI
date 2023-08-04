<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
# Libs
use Vecnavium\FormsUI\FormsUI;

use muqsit\simplepackethandler\SimplePacketHandler;

use CortexPE\Commando\PacketHooker;
use CortexPE\Commando\BaseCommand;

use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use DaPigGuy\libPiggyEconomy\providers\EconomyProvider;
use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;
# My flies
use fernanACM\RepairUI\utils\PluginUtils;

use fernanACM\RepairUI\forms\RepairMenu;
use fernanACM\RepairUI\forms\subforms\RepairForm;
use fernanACM\RepairUI\forms\subforms\LoreForm;
use fernanACM\RepairUI\forms\subforms\RenameForm;
use fernanACM\RepairUI\forms\subforms\CostForm;

use fernanACM\RepairUI\commands\RepairCommand;
use fernanACM\RepairUI\events\EventListener;
use fernanACM\RepairUI\manager\RepairManager;

class RP extends PluginBase{

    /** @var Config $config */
	public Config $config;
    /** @var Config $messages */
	public Config $messages;

    /** @var EconomyProvider $economyProvider */
    private static EconomyProvider $economyProvider;
    /** @var RP $instance */
    private static RP $instance;

    # CheckConfig
    private const CONFIG_VERSION = "1.0.0";
    private const LANGUAGE_VERSION = "1.0.0";

    # MultiLanguages
    private const LANGUAGES = [
        "eng", // English
        "spa", // Spanish
        "indo", //Indonesian
        "ger", // German
        "vie" // Vietnamese
    ];
    

    /**
     * @return void
     */
    public function onLoad(): void{
        self::$instance = $this;
        $this->loadFiles();
    }

    /**
     * @return void
     */
	public function onEnable(): void{
        $this->loadCheck();
        $this->loadVirions();
        $this->loadCommands();
        $this->loadEvents();
	}

    /**
     * @return void
     */
    private function loadFiles(): void{
        # Config files
		@mkdir($this->getDataFolder() . "languages");
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml");
		# Languages
		foreach(self::LANGUAGES as $language){
			$this->saveResource("languages/" . $language . ".yml");
		}
		$this->messages = new Config($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml"); 
    }

    /**
     * @return void
     */
    private function loadCheck(): void{
        # CONFIG
        if((!$this->config->exists("config-version")) || ($this->config->get("config-version") != self::CONFIG_VERSION)){
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->saveResource("config.yml");
            $this->getLogger()->critical("Your configuration file is outdated.");
            $this->getLogger()->notice("Your old configuration has been saved as config_old.yml and a new configuration file has been generated. Please update accordingly.");
        }
        # LANGUAGES
        $data = new Config($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml");
        if((!$data->exists("language-version")) || ($data->get("language-version") != self::LANGUAGE_VERSION)){
            rename($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml", $this->getDataFolder() . "languages/" . $this->config->get("language") . "_old.yml");
            foreach(self::LANGUAGES as $language){
                $this->saveResource("languages/" . $language . ".yml");
            }
            $this->getLogger()->critical("Your ".$this->config->get("language").".yml file is outdated.");
            $this->getLogger()->notice("Your old ".$this->config->get("language").".yml has been saved as ".$this->config->get("language")."_old.yml and a new ".$this->config->get("language").".yml file has been generated. Please update accordingly.");
        }
    }

    /**
     * @return void
     */
    private function loadVirions(): void{
        foreach([
            "libPiggyEconomy" => libPiggyEconomy::class,
            "FormsUI" => FormsUI::class,
            "SimplePacketHandler" => SimplePacketHandler::class,
            "Commando" => BaseCommand::class,
            "libPiggyUpdateChecker" => libPiggyUpdateChecker::class
            ] as $virion => $class
        ){
            if(!class_exists($class)){
                $this->getLogger()->error($virion . " virion not found. Please download RepairUI from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }
        if(!PacketHooker::isRegistered()){
            PacketHooker::register($this);
        }
        # Update
        libPiggyUpdateChecker::init($this);
        # libPiggyEconomy
        libPiggyEconomy::init();
        self::$economyProvider = libPiggyEconomy::getProvider($this->config->get("Economy"));
    }

    /**
     * @return void
     */
    private function loadCommands(): void{
        Server::getInstance()->getCommandMap()->register("repairui", new RepairCommand);
    }

    /**
     * @return void
     */
	private function loadEvents(){    
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener, $this);
	}

    /**
     * @return RP
     */
    public static function getInstance(): RP{
        return self::$instance;
    }

    /**
     * @return RepairManager
     */
    public function getRepairManager(): RepairManager{
        return RepairManager::getInstance();
    }

    /**
     * @return RepairMenu
     */
    public function getRepairMenu(): RepairMenu{
        return RepairMenu::getInstance();
    }

    /**
     * @return RepairForm
     */
    public function getRepairForm(): RepairForm{
        return RepairForm::getInstance();
    }

    /**
     * @return RenameForm
     */
    public function getRenameForm(): RenameForm{
        return RenameForm::getInstance();
    }

    /**
     * @return LoreForm
     */
    public function getLoreForm(): LoreForm{
        return LoreForm::getInstance();
    }

    /**
     * @return CostForm
     */
    public function getCostForm(): CostForm{
        return CostForm::getInstance();
    }

    /**
     * @param Player $player
     * @param string $key
     * @return string
     */
	public static function getMessage(Player $player, string $key): string{
        $messageArray = self::$instance->messages->getNested($key, []);
        if(!is_array($messageArray)){
            $messageArray = [$messageArray];
        }
        $message = implode("\n", $messageArray);
        return PluginUtils::codeUtil($player, $message);
    }

    /**
     * @return EconomyProvider
     */
    public static function getEconomy(): EconomyProvider{
        return self::$economyProvider;
    }

    /**
     * @return string
     */
    public static function Prefix(): string{
        return TextFormat::colorize(self::$instance->config->get("Prefix"));
    }
}