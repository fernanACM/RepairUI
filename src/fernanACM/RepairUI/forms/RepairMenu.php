<?php 
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\forms;

use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\language\LangKey;
use fernanACM\RepairUI\language\Language;
use fernanACM\RepairUI\forms\subforms\CostForm;

final class RepairMenu{
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
	public function open(Player $player): void{
		$item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $player->sendMessage(RP::getPrefix(). Language::getMessage(LangKey::ERROR_NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return;
			}
			switch($data){
				case 0: //REPAIR
					CostForm::getInstance()->repair($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: //RENAME
					CostForm::getInstance()->rename($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: //LORE
					CostForm::getInstance()->lore($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 3: //EXIT
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;
			}
		});
		$form->setTitle(Language::getPlayerMessage($player, LangKey::FORM_MAIN_TITLE));
		$form->setContent(Language::getPlayerMessage($player, LangKey::FORM_MAIN_CONTENT));
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_MAIN_BUTTON_REPAIR),1,"https://i.imgur.com/epmEZCS.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_MAIN_BUTTON_RENAME),1,"https://i.imgur.com/H687H0q.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_MAIN_BUTTON_LORE),1,"https://i.imgur.com/G3r45DG.png");
		$form->addButton(Language::getPlayerMessage($player, LangKey::FORM_MAIN_BUTTON_CLOSE),1,"https://i.imgur.com/hFMBO0N.png");
		$player->sendForm($form);
	}
}