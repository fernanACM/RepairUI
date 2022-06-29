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

declare(strict_types=1);

namespace fernanACM\RepairUI\events\block;

use pocketmine\player\Player;

use pocketmine\item\Item;
use pocketmine\math\Vector3;

class Anvil extends \pocketmine\block\Anvil{
    
	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool{
		return true;
	}
}