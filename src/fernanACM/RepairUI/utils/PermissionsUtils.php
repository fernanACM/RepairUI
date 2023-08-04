<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\utils;

class PermissionsUtils{

    public const REPAIR_MONEY = "repairui.repair.money";
    public const REPAIR_XP = "repairui.repair.xp";

    public const RENAME_MONEY = "repairui.rename.money";
    public const RENAME_XP = "repairui.rename.xp";

    public const LORE_MONEY = "repairui.lore.money";
    public const LORE_XP = "repairui.lore.xp";

    public const REPAIR_ALL = "repairui.repair.all";
    public const REPAIR_HAND = "repairui.repair.hand";
    
    public const HELP = "repairui.help.acm";
    public const CMD = "repairui.cmd.acm";

    public const RENAME_CMD = "repairui.rename.cmd";
    public const LORE_CMD = "repairui.lore.cmd";
}