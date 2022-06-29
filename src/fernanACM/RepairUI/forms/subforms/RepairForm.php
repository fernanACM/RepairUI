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

use davidglitch04\libEco\libEco;

use pocketmine\item\ToolTier;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\Tool;

use fernanACM\RepairUI\RP;
use fernanACM\RepairUI\utils\PluginUtils;

class RepairForm{

	public function RepairMoney(Player $player){
		libEco::myMoney($player, static function(float $myMoney) use($player): void{
			$form = new SimpleForm(function(Player $player, $data){
				if($data !== null){
					switch($data){
						case 0:
						    $prefix = RP::getInstance()->getMessage($player, "Prefix");
						    $amount = RP::getInstance()->config->getNested("RepairCost.Repair.Money");
                            $damage = $player->getInventory()->getItemInHand()->getMeta();
                            $myMoney = libEco::myMoney($player, static function(float $myMoney) use($player, $amount, $damage): void{
                                if($myMoney >= $amount * $damage){
                                    libEco::reduceMoney($player, $amount * $damage, static function(bool $success) use($player, $amount, $damage): void{
                                        if($success){
                                            $item = $player->getInventory()->getItemInHand();
                                            if(($item instanceof Tool) or ($item instanceof Armor)){
                                                if($item->getMeta() !== 0){
                                                    $item->setDamage(0);
                                                    $player->getInventory()->setItemInHand($item);
                                                    $prefix = RP::getInstance()->getMessage($player, "Prefix");
                                                    $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.repair-success"));
                                                    PluginUtils::PlaySound($player, "random.anvil_use", 1, 1);             
                                                }else{
                                                    $prefix = RP::getInstance()->getMessage($player, "Prefix");
						    				        $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-damage"));
						    				        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                                                }
                                            }else{
                                                $prefix = RP::getInstance()->getMessage($player, "Prefix");
						    			        $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-item"));
						    			        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                                            }
                                        }else{
                                            $prefix = RP::getInstance()->getMessage($player, "Prefix");
						    		        $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-money"));
						    		        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                                        }
                                    });
                                }else{
                                    $prefix = RP::getInstance()->getMessage($player, "Prefix");
						    		$player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-money"));
						    		PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                                }
                            });                            
						break;

						case 1:
						    RP::getInstance()->cost->RepairCost($player);
						    PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
						break;
					}
				}
			});            
            $damage = $player->getInventory()->getItemInHand()->getMeta();
			$amount = RP::getInstance()->config->getNested("RepairCost.Repair.Money");
			$msg = RP::getInstance()->getMessage($player, "Forms.RepairMoney.content");
            $prefix = RP::getInstance()->getMessage($player, "Prefix");
			$item = $player->getInventory()->getItemInHand();
            $total = $amount * $damage;
            if($item->getId() == 0){
                $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-item"));
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
			$form->setTitle(RP::getInstance()->getMessage($player, "Forms.RepairMoney.title"));
			$form->setContent(str_replace(["{BALANCE}", "{COST}", "{TOTAL}", "{DAMAGE}"], [$myMoney, $amount, $total, $damage], $msg));
			$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairMoney.button-repair"),1,"https://i.imgur.com/QJiGRVV.png");
			$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairMoney.button-back"),1,"https://i.imgur.com/YzfZ302.png");
			$player->sendForm($form);
		});
	}

	public function RepairXP(Player $player){
		$form = new SimpleForm(function(Player $player, $data){
			if($data !== null){
				switch($data){
					case 0:
					    $prefix = RP::getInstance()->getMessage($player, "Prefix");
					    $amount = RP::getInstance()->config->getNested("RepairCost.Repair.XP");
                        $damage = $player->getInventory()->getItemInHand()->getMeta();
					    $item = $player->getInventory()->getItemInHand();
                        $total = $amount * $damage;
                        if($player->getXpManager()->getXpLevel() >= $amount * $damage){
                            if(($item instanceof Tool) or ($item instanceof Armor)){
                               if($item->getMeta() !== 0){
                                   $item->setDamage(0);
                                   $player->getInventory()->setItemInHand($item);
                                   $player->getXpManager()->subtractXpLevels($total);
                                   $prefix = RP::getInstance()->getMessage($player, "Prefix");
                                   $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.repair-success"));
                                   PluginUtils::PlaySound($player, "random.anvil_use", 1, 1); 
                               }else{
                                   $prefix = RP::getInstance()->getMessage($player, "Prefix");
                        		   $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-damage"));
						    	   PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                               } 
                            }else{
                                $prefix = RP::getInstance()->getMessage($player, "Prefix");
                        	    $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-item"));
						        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                            }
                        }else{
                           $prefix = RP::getInstance()->getMessage($player, "Prefix");
                           $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-xp"));
						   PluginUtils::PlaySound($player, "mob.villager.no", 1, 1); 
                        }
					break;

					case 1:
					    RP::getInstance()->cost->RepairCost($player);
						PluginUtils::PlaySound($player, "random.drink", 1, 1.7);
					break;
				}
			}
		});
        $damage = $player->getInventory()->getItemInHand()->getMeta();
		$amount = RP::getInstance()->config->getNested("RepairCost.Repair.XP");
		$msg = RP::getInstance()->getMessage($player, "Forms.RepairXP.content");
        $prefix = RP::getInstance()->getMessage($player, "Prefix");
		$item = $player->getInventory()->getItemInHand();
        $total = $amount * $damage;
        if($item->getId() == 0){
            $player->sendMessage($prefix . RP::getInstance()->getMessage($player, "Messages.no-item"));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }       
		$form->setTitle(RP::getInstance()->getMessage($player, "Forms.RepairXP.title"));
		$form->setContent(str_replace(["{XP}", "{COST}", "{TOTAL}", "{DAMAGE}"], [$player->getXpManager()->getXpLevel(), $amount, $total, $damage], $msg));
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairXP.button-repair"),1,"https://i.imgur.com/ulnoq5H.png");
		$form->addButton(RP::getInstance()->getMessage($player, "Forms.RepairXP.button-back"),1,"https://i.imgur.com/YzfZ302.png");
		$player->sendForm($form);
	}
}