<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\language;

use pocketmine\player\Player;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\RP as Loader;

final class Language{

    protected const DATAFOLDER_NAME = "languages";

    # MultiLanguages
    public const LANGUAGES = [
        "eng", // English
        "spa", // Spanish
        "ger", // German
        "indo", // Indonesian
        "vie" // Vietnamese
    ];

    /** @var Config $messages */
    protected static Config $messages;

    /**
     * @return void
     */
    public static function init(): void{
        @mkdir(Loader::getInstance()->getDataFolder(). self::DATAFOLDER_NAME);
        foreach(self::LANGUAGES as $language){
            Loader::getInstance()->saveResource(self::DATAFOLDER_NAME."/$language.yml");
        }
        self::loadMessages();
    }

    /**
     * @return void
     */
    public static function loadMessages(): void{
        self::$messages = new Config(Loader::getInstance()->getDataFolder().self::DATAFOLDER_NAME."/".self::getLanguage().".yml");
    }

    /**
     * @return string
     */
    public static function getLanguage(): string{
        return strval(Loader::getInstance()->config->get("language", "eng"));
    }

    /**
     * @param Player $player
     * @param string $key
     * @param array $replaces
     * @return string
     */
    public static function getPlayerMessage(Player $player, string $key, array $replaces = []): string{
        $messageArray = self::$messages->getNested($key, []);
        if(!is_array($messageArray)){
            $messageArray = [$messageArray];
        }
        $message = implode("\n", $messageArray);
        foreach($replaces as $search => $replace){
            $message = str_replace($search, (string)$replace, $message);
        }
        return PluginUtils::codeUtil($player, $message);
    }

    /**
     * @param string $key
     * @param array $replaces
     * @return string
     */
    public static function getMessage(string $key, array $replaces = []): string{
        $messageArray = self::$messages->getNested($key, []);
        if(!is_array($messageArray)){
            $messageArray = [$messageArray];
        }
        $message = implode("\n", $messageArray);
        foreach($replaces as $search => $replace){
            $message = str_replace($search, (string)$replace, $message);
        }
        return TextFormat::colorize($message);
    }
}