<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI\manager;

use pocketmine\player\Player;

use pocketmine\utils\TextFormat;

use pocketmine\item\Armor;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\item\Tool;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;

class RepairManager{

    public const RENAME_MODE = "customName";
    public const LORE_MODE = "loreName";
    
    /** @var RepairManage|null */
    private static $instance = null;

    private function __construct(){    
    }

    /**
     * @param Player $player
     * @param integer $price
     * @return void
     */
    public function getRepairMoney(Player $player, int $price): void{
        $item = $player->getInventory()->getItemInHand();
        $mode = RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode");
        switch($mode){
            case true:
                if(!$item instanceof Durable) return;
                RP::getEconomy()->getMoney($player, function(int|float $myMoney) use($player, $price, $item){
                    $total = $price * $item->getDamage();
                    if($myMoney >= $total){
                        if(!$this->sendRepairedItem($player, $item))return;
                        RP::getEconomy()->takeMoney($player, $total);
                    }else{
                        $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_MONEY));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    }
                });
            break;
            
            case false:
                RP::getEconomy()->getMoney($player, function(int|float $myMoney) use($player, $price, $item): void{
                    if($myMoney >= $price){
                        if(!$this->sendRepairedItem($player, $item))return;
                        RP::getEconomy()->takeMoney($player, $price);
                    }else{
                        $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_MONEY));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    }
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
        $myXp = $player->getXpManager()->getXpLevel();
        $item = $player->getInventory()->getItemInHand();
        $mode = RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode");
        switch($mode){
            case true:
                $damage = $player->getInventory()->getItemInHand();
                if(!$damage instanceof Durable)return;
                $total = $price + $damage->getDamage();
                if($myXp >= $total){
                    if(!$this->sendRepairedItem($player, $item))return;
                    $player->getXpManager()->subtractXp($total);
                }else{
                    $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_XP));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                }
            break;
            
            case false:
                if($myXp >= $price){
                    if(!$this->sendRepairedItem($player, $item))return;
                    $player->getXpManager()->subtractXp($price);
                }else{
                    $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_XP));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                }
            break;
        }
    }

    /**
     * @param Player $player
     * @param Item $item
     * @return boolean
     */
    public function sendRepairedItem(Player $player, Item $item): bool{
        if(!$item instanceof Durable){
            return false;
        }
        if(!$item instanceof Tool && !$item instanceof Armor){
            $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return false;
        }
        if(!$item->getDamage() > 0){
            $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_DAMAGE));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return false;
        }
        $item->setDamage(0);
        $player->getInventory()->setItemInHand($item);
        $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::REPAIR_SUCCESS));
        PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
        return true;
    }

    /**
     * @param Player $player
     * @param Item $item
     * @param string $mode
     * @param string $customName
     * @return void
     */
    public function sendRenamedItem(Player $player, Item $item, string $mode, string $customName): void{
        switch($mode){
            case self::RENAME_MODE:
                $item->setCustomName(str_replace(["{LINE}"], ["\n"], TextFormat::colorize($customName)));
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage(RP::Prefix(). str_replace(["{RENAME}"], [$customName], RP::getMessage($player, WordUtils::RENAME_SUCCESS)));
                PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
            break;

            case self::LORE_MODE:
                $item->setLore([str_replace(["{LINE}"], ["\n"], TextFormat::colorize($customName))]);
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage(RP::Prefix(). str_replace(["{LORE}"], [$customName], RP::getMessage($player, WordUtils::LORE_SUCCESS)));
                PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
            break;
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public function sendInventoryAllRepaired(Player $player): void{
        foreach($player->getInventory()->getContents() as $slot => $item){
            if(!$item instanceof Durable)continue;
            if(!$item instanceof Tool && !$item instanceof Armor)continue;
            if($item->getDamage() > 0){
                $player->getInventory()->setItem($slot, $item->setDamage(0));
            }
        }
    
        foreach($player->getArmorInventory()->getContents() as $armorSlot => $armor){
            if(!$armor instanceof Durable)continue;
            if(!$armor instanceof Tool && !$armor instanceof Armor)continue;
            if($armor->getDamage() > 0){
                $player->getArmorInventory()->setItem($armorSlot, $armor->setDamage(0));
            }
        }
        $player->sendMessage(RP::Prefix() . RP::getMessage($player, WordUtils::REPAIR_ALL_SUCCESS));
        PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
    }    

    /**
     * @param Player $player
     * @return void
     */
    public function sendItemInHandRepaired(Player $player): void{
        $item = $player->getInventory()->getItemInHand();
        if(!$item instanceof Durable)return;
        if(!$item instanceof Tool && !$item instanceof Armor){
            $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        if($item->getDamage() > 0){
            $player->getInventory()->setItemInHand($item->setDamage(0));
        }
        $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::REPAIR_HAND_SUCCESS));
        PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);
    }

    /**
	 * @return self
	 */
	public static function getInstance(): self{
		if(is_null(self::$instance))self::$instance = new self();
        return self::$instance;
	}
}