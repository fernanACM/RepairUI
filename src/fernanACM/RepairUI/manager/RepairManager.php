<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\manager;

use pocketmine\player\Player;

use pocketmine\utils\TextFormat;
use pocketmine\utils\SingletonTrait;

use pocketmine\item\Armor;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\item\Tool;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\language\Language;

final class RepairManager{
    use SingletonTrait{
        setInstance as protected;
        reset as protected;
    }

    public const RENAME_MODE = "customName";
    public const LORE_MODE = "loreName";

    public function __construct(){
        self::setInstance($this);
    }

    /**
     * @param Player $player
     * @param integer $price
     * @return void
     */
    public function getRepairMoney(Player $player, int $price): void{
        $item = $player->getInventory()->getItemInHand();
        $mode = boolval(RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode"));
        switch($mode){
            case true:
                if(!$item instanceof Durable) return;
                RP::getEconomy()->getMoney($player, function(int|float $myMoney) use($player, $price, $item): void{
                    $total = $price * $item->getDamage();
                    if($myMoney < $total){
                        $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_MONEY));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    $this->sendRepairedItem($player, $item, function(bool $result) use($player, $total): void{
                        if($result) RP::getEconomy()->takeMoney($player, $total);
                    });
                });
            break;
            
            case false:
                RP::getEconomy()->getMoney($player, function(int|float $myMoney) use($player, $price, $item): void{
                    if($myMoney < $price){
                        $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_MONEY));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    $this->sendRepairedItem($player, $item, function(bool $result) use($player, $price): void{
                        if($result) RP::getEconomy()->takeMoney($player, $price);
                    });
                });
            break;
        }
    }

    /**
     * @param Player $player
     * @param integer $price
     * @return void
     */
    public function getRepairXp(Player $player, int $price): void{
        $myXp = intval($player->getXpManager()->getXpProgress());
        $item = $player->getInventory()->getItemInHand();
        $mode = boolval(RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode"));
        switch($mode){
            case true:
                $damage = $player->getInventory()->getItemInHand();
                if(!$damage instanceof Durable)return;
                $total = $price * $damage->getDamage();
                if($myXp < $total){
                    $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_XP));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                $this->sendRepairedItem($player, $item, function(bool $result) use($player, $total): void{
                    if($result) $player->getXpManager()->subtractXp($total);
                });
            break;
            
            case false:
                if($myXp < $price){
                    $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_XP));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                $this->sendRepairedItem($player, $item, function(bool $result) use($player, $price): void{
                    if($result) $player->getXpManager()->subtractXp($price);
                });
            break;
        }
    }

    /**
     * @param Player $player
     * @param Item|null $item
     * @param callable|null $callable
     * @return void
     */
    public function sendRepairedItem(Player $player, ?Item $item = null, ?callable $callable = null): void{
        $newItem = $item ?? $player->getInventory()->getItemInHand();
        if($newItem->isNull() || (!($newItem instanceof Durable) && !($newItem instanceof Tool) && !($newItem instanceof Armor))){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        if($newItem->getDamage() < 0){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_DAMAGE));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        if(!is_null($callable)) $callable(true);
        $newItem->setDamage(0);
        $player->getInventory()->setItemInHand($newItem);
        $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::REPAIR_SUCCESS));
        PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
    }

    /**
     * @param Player $player
     * @param Item|null $item
     * @param string $mode
     * @param string $customName
     * @param callable|null $callable
     * @return void
     */
    public function sendRenamedItem(Player $player, ?Item $item, string $mode, string $customName, ?callable $callable = null): void{
        $newItem = $item ?? $player->getInventory()->getItemInHand();
        if($newItem->isNull()){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        switch($mode){
            case self::RENAME_MODE:
                if(empty($customName)){
                    $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_RENAME_NULL));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                if(!is_null($callable)) $callable(true);
                $newItem->setCustomName(str_replace(["{LINE}"], ["\n"], TextFormat::colorize($customName)));
                $player->getInventory()->setItemInHand($newItem);
                $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::RENAME_SUCCESS, ["{RENAME}" => $customName]));
                PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
            break;

            case self::LORE_MODE:
                if(empty($customName)){
                    $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_LORE_NULL));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                if(!is_null($callable)) $callable(true);
                $newItem->setLore([str_replace(["{LINE}"], ["\n"], TextFormat::colorize($customName))]);
                $player->getInventory()->setItemInHand($newItem);
                $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::LORE_SUCCESS, ["{LORE}" => $customName]));
                PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
            break;

            default:
                $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_LORE_NULL));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            break;
        }
    }

    /**
     * @param Player $player
     * @param callable|null $callable
     * @return void
     */
    public function sendInventoryAllRepaired(Player $player, ?callable $callable = null): void{
        foreach($player->getInventory()->getContents() as $slot => $item){
            if(!$item instanceof Durable)continue;
            if(!$item instanceof Tool && !$item instanceof Armor)continue;
            if($item->getDamage() > 0){
                $player->getInventory()->setItem($slot, $item->setDamage(0));
            }
        }
        foreach($player->getOffHandInventory()->getContents() as $slot => $offHanditem){
            if(!$offHanditem instanceof Durable)continue;
            if(!$offHanditem instanceof Tool && !$offHanditem instanceof Armor)continue;
            if($offHanditem->getDamage() > 0){
                $player->getOffHandInventory()->setItem($slot, $offHanditem->setDamage(0));
            }
        }
        foreach($player->getArmorInventory()->getContents() as $armorSlot => $armor){
            if(!$armor instanceof Durable)continue;
            if(!$armor instanceof Tool && !$armor instanceof Armor)continue;
            if($armor->getDamage() > 0){
                $player->getArmorInventory()->setItem($armorSlot, $armor->setDamage(0));
            }
        }
        if(!is_null($callable)) $callable(true);
        $player->sendMessage(RP::getPrefix() . Language::getMessage(LangKey::REPAIR_ALL_SUCCESS));
        PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
    }
}