<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\forms\subforms;

use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;

use pocketmine\item\Durable;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\manager\RepairManager;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\forms\subforms\CostForm;

final class RepairForm{
    use SingletonTrait{
		setInstance as protected;
		reset as protected;
	}

    public function __construct(){
        self::setInstance($this);
    }

    /**
     * @param Player $player
     * @return void
     */
	public function money(Player $player): void{
        $cost = intval(RP::getInstance()->config->getNested("RepairCost.Repair.money-cost"));
        $mode = boolval(RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode"));
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
		RP::getEconomy()->getMoney($player, function(int|float $myMoney) use($player, $cost, $mode, $item): void{
            $form = new SimpleForm(function(Player $player, $data) use($cost){
                if(is_null($data)){
                    CostForm::getInstance()->repair($player);
                    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                    return;
                }
                switch($data){
                    case 0:
                        RepairManager::getInstance()->getRepairMoney($player, $cost);
                    break;

                    case 1:
                        CostForm::getInstance()->repair($player);
                        PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                    break;
                }
            });
            if(!$item instanceof Durable)return;
            $damage = $item->getDamage();
            $form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_MONEY_TITLE));
			if($mode){
                $total = $cost * $damage;
                $form->setContent(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_MONEY_CONTENT_DAMAGE_MODE, [
                    "{BALANCE}" => $myMoney,
                    "{COST}" => $cost,
                    "{TOTAL}" => $total,
                    "{DAMAGE}" => $damage
                ]));
            }else{
                $form->setContent(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_MONEY_CONTENT_NORMAL_MODE, [
                    "{BALANCE}" => $myMoney,
                    "{COST}" => $cost,
                    "{DAMAGE}" => $damage
                ]));
            }
			$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_MONEY_BUTTON_REPAIR),1,"https://i.imgur.com/QJiGRVV.png");
			$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_MONEY_BUTTON_BACK),1,"https://i.imgur.com/YzfZ302.png");
			$player->sendForm($form);
        });
	}

    /**
     * @param Player $player
     * @return void
     */
	public function xp(Player $player): void{
        $cost = intval(RP::getInstance()->config->getNested("RepairCost.Repair.xp-cost"));
        $mode = boolval(RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode"));
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        $form = new SimpleForm(function(Player $player, $data) use($cost){
            if(is_null($data)){
                CostForm::getInstance()->repair($player);
                PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                return;
            }
            switch($data){
                case 0:
                    RepairManager::getInstance()->getRepairXp($player, $cost);
                break;

                case 1:
                    CostForm::getInstance()->repair($player);
                    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                break;
            }
        });
        if(!$item instanceof Durable)return;
        $damage = $item->getDamage();
        $form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_XP_TITLE));
        if($mode){
            $total = $cost * $damage;
            $form->setContent(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_XP_CONTENT_DAMAGE_MODE, [
                "{XP}" => intval($player->getXpManager()->getXpProgress()),
                "{COST}" => $cost,
                "{TOTAL}" => $total,
                "{DAMAGE}" => $damage
            ]));
        }else{
            $form->setContent(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_XP_CONTENT_NORMAL_MODE, [
                "{XP}" => intval($player->getXpManager()->getXpProgress()),
                "{COST}" => $cost,
                "{DAMAGE}" => $damage
            ]));
        }
        $form->addButton(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_XP_BUTTON_REPAIR),1,"https://i.imgur.com/QJiGRVV.png");
        $form->addButton(Language::getPlayerMessage($player, LangKey::FORM_REPAIR_XP_BUTTON_BACK),1,"https://i.imgur.com/YzfZ302.png");
        $player->sendForm($form);
	}
}
