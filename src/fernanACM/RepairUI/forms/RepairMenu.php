<?php 

#  ____                           _          _   _   ___ 
# |  _ \    ___   _ __     __ _  (_)  _ __  | | | | |_ _|
# | |_) |  / _ \ | '_ \   / _` | | | | '__| | | | |  | | 
# |  _ <  |  __/ | |_) | | (_| | | | | |    | |_| |  | | 
# |_| \_\  \___| | .__/   \__,_| |_| |_|     \___/  |___|
#                |_|                                     
#   Copyright [2022-2022] [fernanACM]

#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at

#       http://www.apache.org/licenses/LICENSE-2.0

#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.

namespace fernanACM\RepairUI\forms;

use pocketmine\Server;
use pocketmine\player\Player;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class RepairMenu{

	public function RepairMenu(Player $player){
		$form = new SimpleForm(function(Player $player, $data){
			if($data !== null){
				switch($data){
					case 0: //REPAIR
					    RP::getInstance()->cost->RepairCost($player);
					    PluginUtils::PlaySound($player, "random.pop", 1, 1);
					break;

					case 1: //RENAME
					    RP::getInstance()->cost->RenameCost($player);
					    PluginUtils::PlaySound($player, "random.pop", 1, 1);
					break;

					case 2: //LORE
					    RP::getInstance()->cost->LoreCost($player);
					    PluginUtils::PlaySound($player, "random.pop", 1, 1);
					break;

					case 3: //EXIT
					    PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
					break;
				}
			}
		});
        $prefix = RP::getInstance()->getMessage($player, "Prefix");
        $item = $player->getInventory()->getItemInHand();
        if($item->getId() == 0){
            $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-item"));
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
}