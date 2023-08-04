<?php 
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\RepairUI\forms;

use pocketmine\player\Player;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;
use fernanACM\RepairUI\utils\WordUtils;
use fernanACM\RepairUI\forms\subforms\CostForm;

class RepairMenu{

	/** @var RepairMenu|null $instance */
	private static $instance = null;

	private function __construct(){		
	}

	/**
	 * @param Player $player
	 * @return void
	 */
	public function getRepairMenu(Player $player): void{
		$form = new SimpleForm(function(Player $player, $data){
			if(is_null($data)){
				PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				return true;
			}
			switch($data){
				case 0: //REPAIR
					CostForm::getInstance()->getRepairCost($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 1: //RENAME
					CostForm::getInstance()->getRenameCost($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 2: //LORE
					CostForm::getInstance()->getLoreCost($player);
					PluginUtils::PlaySound($player, "random.pop", 1, 1);
				break;

				case 3: //EXIT
					PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
				break;
			}
		});
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $player->sendMessage(RP::Prefix(). RP::getMessage($player, WordUtils::NO_ITEM));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
		$form->setTitle(RP::getInstance()->getMessage($player, "Forms.RepairMenu.title"));
		$form->setContent(RP::getInstance()->getMessage($player, "Forms.RepairMenu.content"));
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairMenu.button-repair"),1,"https://i.imgur.com/epmEZCS.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairMenu.button-rename"),1,"https://i.imgur.com/H687H0q.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairMenu.button-lore"),1,"https://i.imgur.com/G3r45DG.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairMenu.button-exit"),1,"https://i.imgur.com/hFMBO0N.png");
		$player->sendForm($form);
	}

	/**
	 * @return self
	 */
	public static function getInstance(): self{
		if(is_null(self::$instance))self::$instance = new self();
        return self::$instance;
	}
}