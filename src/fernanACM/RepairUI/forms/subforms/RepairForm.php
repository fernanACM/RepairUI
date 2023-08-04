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

use pocketmine\item\Durable;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\manager\RepairManager;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;
use fernanACM\RepairUI\forms\subforms\CostForm;

class RepairForm{

    /** @var RepairForm|null $instance */
    private static ?RepairForm $instance = null;

    private function __construct(){
    }

    /**
     * @param Player $player
     * @return void
     */
	public function getRepairMoney(Player $player): void{
        $amount = RP::getInstance()->config->getNested("RepairCost.Repair.money-cost");
        $mode = RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode");
        $item = $player->getInventory()->getItemInHand();
		RP::getEconomy()->getMoney($player, static function(int|float $myMoney) use($player, $amount, $mode, $item): void{
            $form = new SimpleForm(function(Player $player, $data) use($amount){
                if(is_null($data)){
                    CostForm::getInstance()->getRepairCost($player);
                    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                    return true;
                }
                switch($data){
                    case 0:
                        RepairManager::getInstance()->getRepairMoney($player, $amount);
                    break;

                    case 1:
                        CostForm::getInstance()->getRepairCost($player);
                        PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                    break;
                }
            });
            if($item->isNull()){
                $player->sendMessage(RP::Prefix() . RP::getMessage($player, WordUtils::NO_ITEM));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
            if(!$item instanceof Durable)return;
            $damage = $item->getDamage();
            $form->setTitle(RP::getMessage($player, "Forms.RepairMoney.title"));
			if($mode){
                $content = RP::getMessage($player, "Forms.RepairMoney.content-damage-mode");
                $total = $amount * $damage;
                $form->setContent(str_replace(["{BALANCE}", "{COST}", "{TOTAL}", "{DAMAGE}"], [$myMoney, $amount, $total, $damage], $content));
            }else{
                $content = RP::getMessage($player, "Forms.RepairMoney.content-normal-mode");
                $form->setContent(str_replace(["{BALANCE}", "{COST}", "{DAMAGE}"], [$myMoney, $amount, $damage], $content));
            }
			$form->addButton(RP::getMessage($player, "Forms.RepairMoney.button-repair"),1,"https://i.imgur.com/QJiGRVV.png");
			$form->addButton(RP::getMessage($player, "Forms.RepairMoney.button-back"),1,"https://i.imgur.com/YzfZ302.png");
			$player->sendForm($form);
        });
	}

    /**
     * @param Player $player
     * @return void
     */
	public function getRepairXP(Player $player): void{
        $amount = RP::getInstance()->config->getNested("RepairCost.Repair.xp-cost");
        $mode = RP::getInstance()->config->getNested("RepairCost.Repair.damage-mode");
        $item = $player->getInventory()->getItemInHand();
        $form = new SimpleForm(function(Player $player, $data) use($amount){
            if(is_null($data)){
                CostForm::getInstance()->getRepairCost($player);
                PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                return true;
            }
            switch($data){
                case 0:
                    RepairManager::getInstance()->getRepairXp($player, $amount);
                break;

                case 1:
                    CostForm::getInstance()->getRepairCost($player);
                    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
                break;
            }
        });
        if($item->isNull()){
            $player->sendMessage(RP::Prefix() . RP::getMessage($player, WordUtils::NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        if(!$item instanceof Durable)return;
        $damage = $item->getDamage();
        $form->setTitle(RP::getMessage($player, "Forms.RepairXP.title"));
        if($mode){
            $content = RP::getMessage($player, "Forms.RepairXP.content-damage-mode");
            $total = $amount + $damage;
            $form->setContent(str_replace(["{XP}", "{COST}", "{TOTAL}", "{DAMAGE}"], [$player->getXpManager()->getXpLevel(), $amount, $total, $damage], $content));
        }else{
            $content = RP::getMessage($player, "Forms.RepairXP.content-normal-mode");
            $form->setContent(str_replace(["{XP}", "{COST}", "{DAMAGE}"], [$player->getXpManager()->getXpLevel(), $amount, $damage], $content));
        }
        $form->addButton(RP::getMessage($player, "Forms.RepairXP.button-repair"),1,"https://i.imgur.com/QJiGRVV.png");
        $form->addButton(RP::getMessage($player, "Forms.RepairXP.button-back"),1,"https://i.imgur.com/YzfZ302.png");
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
