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

use Vecnavium\FormsUI\CustomForm;

use fernanACM\RepairUI\manager\RepairManager;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\forms\subforms\CostForm;

final class RenameForm{
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
        $cost = intval(RP::getInstance()->config->getNested("RepairCost.Rename.money-cost"));
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
		RP::getEconomy()->getMoney($player, function(int|float $myMoney) use($player, $cost, $item): void{
			$form = new CustomForm(function(Player $player, $data) use($myMoney, $cost, $item){
                if(is_null($data)){
                    CostForm::getInstance()->rename($player);
                    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                    return;
                }
                if(empty($data[1])){
                    $player->sendMessage(RP::getPrefix() . Language::getMessage(LangKey::ERROR_RENAME_NULL));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                if($myMoney < $cost){
                    $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_MONEY));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                RepairManager::getInstance()->sendRenamedItem($player, $item, RepairManager::RENAME_MODE, strval($data[1]), function(bool $result) use($player, $cost): void{
                    if($result) RP::getEconomy()->takeMoney($player, $cost);
                });
            });
            $form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_RENAME_MONEY_TITLE));
            $form->addLabel(Language::getPlayerMessage($player, LangKey::FORM_RENAME_MONEY_CONTENT, [
                "{BALANCE}" => $myMoney,
                "{COST}" => $cost
            ]));
            $form->addInput(Language::getPlayerMessage($player, LangKey::FORM_RENAME_MONEY_INPUT_1), Language::getPlayerMessage($player, LangKey::FORM_RENAME_MONEY_INPUT_2));
            $player->sendForm($form);
		});
	}

    /**
     * @param Player $player
     * @return void
     */
	public function xp(Player $player): void{
        $cost = intval(RP::getInstance()->config->getNested("RepairCost.Rename.xp-cost"));
        $myXp = intval($player->getXpManager()->getXpProgress());
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
		$form = new CustomForm(function(Player $player, $data) use($myXp, $cost, $item){
            if(is_null($data)){
                CostForm::getInstance()->rename($player);
                PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                return;
            }
            if(empty($data[1])){
                $player->sendMessage(RP::getPrefix() . Language::getMessage(LangKey::ERROR_RENAME_NULL));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
            if($myXp < $cost){
                $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_XP));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
            RepairManager::getInstance()->sendRenamedItem($player, $item, RepairManager::RENAME_MODE, strval($data[1]), function(bool $result) use($player, $cost): void{
                if($result) $player->getXpManager()->subtractXp($cost);
            });
        });	
		$form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_RENAME_XP_TITLE));
        $form->addLabel(Language::getPlayerMessage($player, LangKey::FORM_RENAME_XP_CONTENT, [
            "{XP}" => $myXp,
            "{COST}" => $cost
        ]));
        $form->addInput(Language::getPlayerMessage($player, LangKey::FORM_RENAME_XP_INPUT_1), Language::getPlayerMessage($player, LangKey::FORM_RENAME_XP_INPUT_2));
        $player->sendForm($form);
	}
}