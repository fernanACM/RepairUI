<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\manager;

use pocketmine\utils\SingletonTrait;

use fernanACM\RepairUI\forms\RepairMenu;
use fernanACM\RepairUI\forms\subforms\RepairForm;
use fernanACM\RepairUI\forms\subforms\LoreForm;
use fernanACM\RepairUI\forms\subforms\RenameForm;
use fernanACM\RepairUI\forms\subforms\CostForm;

final class FormManeger{
    use SingletonTrait{
		setInstance as protected;
		reset as protected;
	}

    public function __construct(){
        self::setInstance($this);
    }

    /**
     * @return RepairMenu
     */
    public function getMenu(): RepairMenu{
        return RepairMenu::getInstance();
    }

    /**
     * @return RepairForm
     */
    public function getRepair(): RepairForm{
        return RepairForm::getInstance();
    }

    /**
     * @return RenameForm
     */
    public function getRename(): RenameForm{
        return RenameForm::getInstance();
    }

    /**
     * @return LoreForm
     */
    public function getLore(): LoreForm{
        return LoreForm::getInstance();
    }

    /**
     * @return CostForm
     */
    public function getCost(): CostForm{
        return CostForm::getInstance();
    }
}