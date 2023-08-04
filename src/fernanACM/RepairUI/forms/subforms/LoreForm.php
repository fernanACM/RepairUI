<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI\forms\subforms;

use pocketmine\player\Player;

use Vecnavium\FormsUI\CustomForm;

use fernanACM\RepairUI\manager\RepairManager;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;
use fernanACM\RepairUI\forms\subforms\CostForm;

class LoreForm{

    /** @var LoreForm|null $instance */
    private static ?LoreForm $instance = null;

    private function __construct(){
    }

    /**
     * @param Player $player
     * @return void
     */
	public function getLoreMoney(Player $player): void{
        $amount = RP::getInstance()->config->getNested("RepairCost.Lore.money-cost");
        $item = $player->getInventory()->getItemInHand();
		RP::getEconomy()->getMoney($player, static function(float $myMoney) use($player, $amount, $item): void{
            $form = new CustomForm(function(Player $player, $data) use($amount, $item){
                if(is_null($data)){
                    CostForm::getInstance()->getLoreCost($player);
                    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                    return true;
                }
                if(empty($data[1])){
                    $player->sendMessage(RP::Prefix() . RP::getMessage($player, WordUtils::LORE_NULL));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    return;
                }
                RP::getEconomy()->takeMoney($player, $amount, static function(bool $success) use($player, $data, $item): void{
                    if($success){
                        RepairManager::getInstance()->sendRenamedItem($player, $item, RepairManager::LORE_MODE, $data[1]);
                    }else{
                        $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_MONEY));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    }
                });
            });
			$message = str_replace(["{BALANCE}", "{COST}"], [$myMoney, $amount], RP::getMessage($player, "Forms.LoreMoney.content"));
            if($item->isNull()){
                $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_ITEM));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
            $form->setTitle(RP::getMessage($player, "Forms.LoreMoney.title"));
            $form->addLabel($message);
            $form->addInput(RP::getMessage($player, "Forms.LoreMoney.input1"), RP::getMessage($player, "Forms.LoreMoney.input2"));
            $player->sendForm($form);
		});
	}

    /**
     * @param Player $player
     * @return void
     */
	public function getLoreXP(Player $player): void{
        $amount = RP::getInstance()->config->getNested("RepairCost.Lore.xp-cost");
        $item = $player->getInventory()->getItemInHand();
		$form = new CustomForm(function(Player $player, $data) use($amount, $item){
            if(is_null($data)){
                CostForm::getInstance()->getLoreCost($player);
                PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                return true;
            }
            if(empty($data[1])){
                $player->sendMessage(RP::Prefix() . RP::getMessage($player, WordUtils::LORE_NULL));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
            if($player->getXpManager()->getXpLevel() >= $amount){
                RepairManager::getInstance()->sendRenamedItem($player, $item, RepairManager::LORE_MODE, $data[1]);
                $player->getXpManager()->subtractXp($amount);
            }else{
                $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_XP));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            }
        });	
		$message = str_replace(["{XP}", "{COST}"], [$player->getXpManager()->getXpLevel(), $amount], RP::getMessage($player, "Forms.LoreXP.content"));
        if($item->isNull()){
            $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        $form->setTitle(RP::getMessage($player, "Forms.LoreXP.title"));
        $form->addLabel($message);
        $form->addInput(RP::getMessage($player, "Forms.LoreXP.input1"), RP::getMessage($player, "Forms.LoreXP.input2"));
        $player->sendForm($form);
	}

    /**
     * @return self
     */
    public static function getInstance(): self{
        if(is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }
}