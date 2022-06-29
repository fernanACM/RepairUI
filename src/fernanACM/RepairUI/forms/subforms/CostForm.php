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

namespace fernanACM\RepairUI\forms\subforms;

use pocketmine\Server;
use pocketmine\player\Player;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class CostForm{

	public function RepairCost(Player $player){
		$form = new SimpleForm(function(Player $player, $data){
			if($data !== null){
				switch($data){
					case 0: //MONEY
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    if($player->hasPermission("repairui.repair.money")){
					    	RP::getInstance()->repair->RepairMoney($player);
					    	PluginUtils::PlaySound($player, "random.pop", 1, 1);
					    }else{
					    	$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-permission"));
					    	PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
					    }
					break;

					case 1: //XP
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    if($player->hasPermission("repairui.repair.xp")){
					    	RP::getInstance()->repair->RepairXP($player);
					    	PluginUtils::PlaySound($player, "random.pop", 1, 1);
					    }else{
					    	$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-permission"));
					    	PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
					    }
					break;

					case 2: //BACk
					    RP::getInstance()->repairmenu->RepairMenu($player);
					    PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
					break;
				}
			}
		});
		$form->setTitle(RP::getInstance()->getMessage($player, "Forms.CostForm.Repair.title"));
		$form->setContent(RP::getInstance()->getMessage($player, "Forms.CostForm.Repair.content"));
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Repair.button-money"),1,"https://i.imgur.com/0S37esk.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Repair.button-xp"),1,"https://i.imgur.com/PR3eTLe.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Repair.button-back"),1,"https://i.imgur.com/YzfZ302.png");
		$player->sendForm($form);
	}

	public function RenameCost(Player $player){
		$form = new SimpleForm(function(Player $player, $data){
			if($data !== null){
				switch($data){
					case 0: //MONEY
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    if($player->hasPermission("repairui.rename.money")){
					    	RP::getInstance()->rename->RenameMoney($player);
					    	PluginUtils::PlaySound($player, "random.pop", 1, 1);
					    }else{
					    	$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-permission"));
					    	PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
					    }
					break;

					case 1: //XP
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    if($player->hasPermission("repairui.rename.xp")){
					    	RP::getInstance()->rename->RenameXP($player);
					    	PluginUtils::PlaySound($player, "random.pop", 1, 1);
					    }else{
					    	$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-permission"));
					    	PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
					    }
					break;
 
					case 2: //BACK
					    RP::getInstance()->repairmenu->RepairMenu($player);
					    PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
					break;
				}
			}
		});
		$form->setTitle(RP::getInstance()->getMessage($player, "Forms.CostForm.Rename.title"));
		$form->setContent(RP::getInstance()->getMessage($player, "Forms.CostForm.Rename.content"));
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Rename.button-money"),1,"https://i.imgur.com/0S37esk.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Rename.button-xp"),1,"https://i.imgur.com/PR3eTLe.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Rename.button-back"),1,"https://i.imgur.com/YzfZ302.png");
		$player->sendForm($form);
	}

	public function LoreCost(Player $player){
		$form = new SimpleForm(function(Player $player, $data){
			if($data !== null){
				switch($data){
					case 0: //MONEY
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    if($player->hasPermission("repairui.lore.money")){
					    	RP::getInstance()->lore->LoreMoney($player);
					    	PluginUtils::PlaySound($player, "random.pop", 1, 1);
					    }else{
					    	$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-permission"));
					    	PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
					    }
					break;

					case 1: //XP
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    if($player->hasPermission("repairui.lore.xp")){
					    	RP::getInstance()->lore->LoreXP($player);
					    	PluginUtils::PlaySound($player, "random.pop", 1, 1);
					    }else{
					    	$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-permission"));
					    	PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
					    }
					break;

					case 2: //BACK
					    RP::getInstance()->repairmenu->RepairMenu($player);
					    PluginUtils::PlaySound($player, "random.pop2", 1, 1.7);
					break;
				}
			}
		});
		$form->setTitle(RP::getInstance()->getMessage($player, "Forms.CostForm.Lore.title"));
		$form->setContent(RP::getInstance()->getMessage($player, "Forms.CostForm.Lore.content"));
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Lore.button-money"),1,"https://i.imgur.com/0S37esk.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Lore.button-xp"),1,"https://i.imgur.com/PR3eTLe.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.CostForm.Lore.button-back"),1,"https://i.imgur.com/YzfZ302.png");
		$player->sendForm($form);
	}
}