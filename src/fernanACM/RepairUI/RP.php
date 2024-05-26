<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\utils\SingletonTrait;
# Libs
use Vecnavium\FormsUI\FormsUI;

use muqsit\simplepackethandler\SimplePacketHandler;

use CortexPE\Commando\PacketHooker;
use CortexPE\Commando\BaseCommand;

use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use DaPigGuy\libPiggyEconomy\providers\EconomyProvider;
use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;
# My flies
use fernanACM\RepairUI\commands\RepairCommand;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\manager\FormManager;
use fernanACM\RepairUI\manager\RepairManager;

class RP extends PluginBase{
    use SingletonTrait{
		setInstance as protected;
		reset as protected;
	}

    /** @var Config $config */
	public Config $config;

    /** @var EconomyProvider $economyProvider */
    protected static EconomyProvider $economyProvider;

    # CheckConfig
    protected const CONFIG_VERSION = "1.0.0";
    protected const LANGUAGE_VERSION = "2.0.0";

    /**
     * @return void
     */
    public function onLoad(): void{
        self::setInstance($this);
        $this->loadFiles();
        $this->loadCheck();
    }

    /**
     * @return void
     */
	public function onEnable(): void{
        $this->loadVirions();
        $this->loadCommands();
        $this->loadEvents();
	}

    /**
     * @return void
     */
    protected function loadFiles(): void{
        # Config files
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml");
		# Languages
		Language::init();
    }

    /**
     * @return void
     */
    protected function loadCheck(): void{
        # CONFIG
        if((!$this->config->exists("config-version")) || ($this->config->get("config-version") != self::CONFIG_VERSION)){
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->saveResource("config.yml");
            $this->getLogger()->critical("Your configuration file is outdated.");
            $this->getLogger()->notice("Your old configuration has been saved as config_old.yml and a new configuration file has been generated. Please update accordingly.");
            $this->config->reload();
        }
        # LANGUAGES
        $data = new Config($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml");
        if((!$data->exists("language-version")) || ($data->get("language-version") != self::LANGUAGE_VERSION)){
            rename($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml", $this->getDataFolder() . "languages/" . $this->config->get("language") . "_old.yml");
            foreach(Language::LANGUAGES as $language){
                $this->saveResource("languages/".$language.".yml");
            }
            $this->getLogger()->critical("Your ".$this->config->get("language").".yml file is outdated.");
            $this->getLogger()->notice("Your old ".$this->config->get("language").".yml has been saved as ".$this->config->get("language")."_old.yml and a new ".$this->config->get("language").".yml file has been generated. Please update accordingly.");
            $data->reload();
        }
    }

    /**
     * @return void
     */
    protected function loadVirions(): void{
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
        if(!PacketHooker::isRegistered()) PacketHooker::register($this);
        # Update
        libPiggyUpdateChecker::init($this);
        # libPiggyEconomy
        libPiggyEconomy::init();
        self::$economyProvider = libPiggyEconomy::getProvider($this->config->get("Economy"));
    }

    /**
     * @return void
     */
    protected function loadCommands(): void{
        $this->getServer()->getCommandMap()->register("repairui", new RepairCommand);
    }

    /**
     * @return void
     */
	protected function loadEvents(){    
        $this->getServer()->getPluginManager()->registerEvents(new Event, $this);
	}

    /**
     * @return RepairManager
     */
    public function getRepairManager(): RepairManager{
        return RepairManager::getInstance();
    }

    /**
     * @return FormManager
     */
    public function getFormManager(): FormManager{
        return FormManager::getInstance();
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
    public static function getPrefix(): string{
        return TextFormat::colorize(self::$instance->config->get("Prefix"));
    }
}