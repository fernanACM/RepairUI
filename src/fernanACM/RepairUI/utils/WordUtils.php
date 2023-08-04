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

class WordUtils{

    // ERROR
    public const NO_PERMISSION = "Messages.error.no-permission";
    public const NO_MONEY = "Messages.error.no-money";
    public const NO_XP = "Messages.error.no-xp";

    public const NO_ITEM = "Messages.error.no-item";

    public const LORE_NULL = "Messages.error.lore-null";
    public const RENAME_NULL = "Messages.error.rename-null";
    
    public const NO_DAMAGE = "Messages.error.no-damage";

    // SUCCESS
    public const REPAIR_SUCCESS = "Messages.success.repair-success";
    public const REPAIR_ALL_SUCCESS = "Messages.success.repair-all-success";
    public const REPAIR_HAND_SUCCESS = "Messages.success.repair-hand-success";

    public const RENAME_SUCCESS = "Messages.success.rename-success";
    public const LORE_SUCCESS = "Messages.success.lore-success";
}