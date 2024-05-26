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

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\forms\RepairMenu;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\permissions\Perms;

final class CostForm{
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
	public function repair(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				RepairMenu::getInstance()->open($player);
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: // MONEY
					if(!$player->hasPermission(Perms::REPAIR_MONEY)){
						$player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RepairForm::getInstance()->money($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: // XP
					if(!$player->hasPermission(Perms::REPAIR_MONEY)){
						$player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RepairForm::getInstance()->xp($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: // RETURN
					RepairMenu::getInstance()->open($player);
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;
			}
		});
		$form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_COST_REPAIR_TITLE));
		$form->setContent(Language::getPlayerMessage($player, LangKey::FORM_COST_REPAIR_CONTENT));
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_REPAIR_BUTTON_MONEY),1,"https://i.postimg.cc/BZwFt8dS/ad5ca2.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_REPAIR_BUTTON_XP),1,"https://i.postimg.cc/MKCjbC6g/ecbc6.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_REPAIR_BUTTON_BACK),1,"https://i.postimg.cc/VN1r2XbR/f2908e.png");
		$player->sendForm($form);
	}

	/**
	 * @param Player $player
	 * @return void
	 */
	public function rename(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				RepairMenu::getInstance()->open($player);
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: // MONEY
					if(!$player->hasPermission(Perms::RENAME_MONEY)){
						$player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RenameForm::getInstance()->money($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: // XP
					if(!$player->hasPermission(Perms::RENAME_MONEY)){
						$player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					RenameForm::getInstance()->xp($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: // RETURN
					RepairMenu::getInstance()->open($player);
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;
			}
		});
		$form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_COST_RENAME_TITLE));
		$form->setContent(Language::getPlayerMessage($player, LangKey::FORM_COST_RENAME_CONTENT));
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_RENAME_BUTTON_MONEY),1,"https://i.postimg.cc/BZwFt8dS/ad5ca2.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_RENAME_BUTTON_XP),1,"https://i.postimg.cc/MKCjbC6g/ecbc6.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_RENAME_BUTTON_BACK),1,"https://i.postimg.cc/VN1r2XbR/f2908e.png");
		$player->sendForm($form);
	}

	/**
	 * @param Player $player
	 * @return void
	 */
	public function lore(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				RepairMenu::getInstance()->open($player);
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: // MONEY
					if(!$player->hasPermission(Perms::LORE_MONEY)){
						$player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					LoreForm::getInstance()->money($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: // XP
					if(!$player->hasPermission(Perms::LORE_MONEY)){
						$player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_PERMISSION));
						PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
						return;
					}
					LoreForm::getInstance()->xp($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: // RETURN
					RepairMenu::getInstance()->open($player);
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;

			}
		});
		$form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_COST_LORE_TITLE));
		$form->setContent(Language::getPlayerMessage($player, LangKey::FORM_COST_LORE_CONTENT));
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_LORE_BUTTON_MONEY),1,"https://i.postimg.cc/BZwFt8dS/ad5ca2.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_LORE_BUTTON_XP),1,"https://i.postimg.cc/MKCjbC6g/ecbc6.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_COST_LORE_BUTTON_BACK),1,"https://i.postimg.cc/VN1r2XbR/f2908e.png");
		$player->sendForm($form);
	}
}