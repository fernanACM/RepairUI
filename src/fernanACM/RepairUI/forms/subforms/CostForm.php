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

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\forms\RepairMenu;
use fernanACM\RepairUI\utils\PermissionsUtils;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;

class CostForm{

	/** @var CostForm|null $instance */
	private static ?CostForm $instance = null;

	private function __construct(){
	}

	/**
	 * @param Player $player
	 * @return void
	 */
	public function getRepairCost(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				RepairMenu::getInstance()->getRepairMenu($player);
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: // MONEY
					if(!$player->hasPermission(PermissionsUtils::REPAIR_MONEY)){
						$player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RepairForm::getInstance()->getRepairMoney($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: // XP
					if(!$player->hasPermission(PermissionsUtils::REPAIR_MONEY)){
						$player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RepairForm::getInstance()->getRepairXP($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: // RETURN
					RepairMenu::getInstance()->getRepairMenu($player);
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;
			}
		});
		$form->setTitle(RP::getMessage($player, "Forms.CostForm.Repair.title"));
		$form->setContent(RP::getMessage($player, "Forms.CostForm.Repair.content"));
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Repair.button-money"),1,"https://i.imgur.com/0S37esk.png");
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Repair.button-xp"),1,"https://i.imgur.com/PR3eTLe.png");
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Repair.button-back"),1,"https://i.imgur.com/YzfZ302.png");
		$player->sendForm($form);
	}

	/**
	 * @param Player $player
	 * @return void
	 */
	public function getRenameCost(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				RepairMenu::getInstance()->getRepairMenu($player);
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: // MONEY
					if(!$player->hasPermission(PermissionsUtils::RENAME_MONEY)){
						$player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RenameForm::getInstance()->getRenameMoney($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: // XP
					if(!$player->hasPermission(PermissionsUtils::RENAME_MONEY)){
						$player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RenameForm::getInstance()->getRenameXP($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: // RETURN
					RepairMenu::getInstance()->getRepairMenu($player);
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;
			}
		});
		$form->setTitle(RP::getMessage($player, "Forms.CostForm.Rename.title"));
		$form->setContent(RP::getMessage($player, "Forms.CostForm.Rename.content"));
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Rename.button-money"),1,"https://i.imgur.com/0S37esk.png");
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Rename.button-xp"),1,"https://i.imgur.com/PR3eTLe.png");
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Rename.button-back"),1,"https://i.imgur.com/YzfZ302.png");
		$player->sendForm($form);
	}

	/**
	 * @param Player $player
	 * @return void
	 */
	public function getLoreCost(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				RepairMenu::getInstance()->getRepairMenu($player);
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: // MONEY
					if(!$player->hasPermission(PermissionsUtils::LORE_MONEY)){
						$player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					LoreForm::getInstance()->getLoreMoney($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: // XP
					if(!$player->hasPermission(PermissionsUtils::LORE_MONEY)){
						$player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					LoreForm::getInstance()->getLoreXP($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: // RETURN
					RepairMenu::getInstance()->getRepairMenu($player);
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;

			}
		});
		$form->setTitle(RP::getMessage($player, "Forms.CostForm.Lore.title"));
		$form->setContent(RP::getMessage($player, "Forms.CostForm.Lore.content"));
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Lore.button-money"),1,"https://i.imgur.com/0S37esk.png");
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Lore.button-xp"),1,"https://i.imgur.com/PR3eTLe.png");
		$form->addButton(RP::getMessage($player, "Forms.CostForm.Lore.button-back"),1,"https://i.imgur.com/YzfZ302.png");
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