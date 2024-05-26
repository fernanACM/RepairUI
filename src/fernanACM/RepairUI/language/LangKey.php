<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\RepairUI\language;

final class LangKey{
    // ERROR
    public const ERROR_NO_PERMISSION = "Messages.error.no-permission";
    public const ERROR_NO_MONEY = "Messages.error.no-money";
    public const ERROR_NO_XP = "Messages.error.no-xp";

    public const ERROR_NO_ITEM = "Messages.error.no-item";

    public const ERROR_LORE_NULL = "Messages.error.lore-null";
    public const ERROR_RENAME_NULL = "Messages.error.rename-null";
    
    public const ERROR_NO_DAMAGE = "Messages.error.no-damage";

    public const ERROR_CUSTOM_NAME_PROVIDER = "Messages.error.custom-name-provider";

    // SUCCESS
    public const REPAIR_SUCCESS = "Messages.success.repair-success";
    public const REPAIR_ALL_SUCCESS = "Messages.success.repair-all-success";
    public const REPAIR_HAND_SUCCESS = "Messages.success.repair-hand-success";

    public const RENAME_SUCCESS = "Messages.success.rename-success";
    public const LORE_SUCCESS = "Messages.success.lore-success";

    // FORMS
    public const FORM_MAIN_TITLE = "Forms.RepairMenu.title";
    public const FORM_MAIN_CONTENT = "Forms.RepairMenu.content";
    public const FORM_MAIN_BUTTON_REPAIR = "Forms.RepairMenu.button-repair";
    public const FORM_MAIN_BUTTON_RENAME = "Forms.RepairMenu.button-rename";
    public const FORM_MAIN_BUTTON_LORE = "Forms.RepairMenu.button-lore";
    public const FORM_MAIN_BUTTON_CLOSE = "Forms.RepairMenu.button-close";

    public const FORM_REPAIR_MONEY_TITLE = "Forms.RepairMoney.title";
    public const FORM_REPAIR_MONEY_CONTENT_DAMAGE_MODE = "Forms.RepairMoney.content-damage-mode";
    public const FORM_REPAIR_MONEY_CONTENT_NORMAL_MODE = "Forms.RepairMoney.content-normal-mode";
    public const FORM_REPAIR_MONEY_BUTTON_REPAIR = "Forms.RepairMoney.button-repair";
    public const FORM_REPAIR_MONEY_BUTTON_BACK = "Forms.RepairMoney.button-back";

    public const FORM_REPAIR_XP_TITLE = "Forms.RepairXP.title";
    public const FORM_REPAIR_XP_CONTENT_DAMAGE_MODE = "Forms.RepairXP.content-damage-mode";
    public const FORM_REPAIR_XP_CONTENT_NORMAL_MODE = "Forms.RepairXP.content-normal-mode";
    public const FORM_REPAIR_XP_BUTTON_REPAIR = "Forms.RepairXP.button-repair";
    public const FORM_REPAIR_XP_BUTTON_BACK = "Forms.RepairXP.button-back";

    public const FORM_RENAME_MONEY_TITLE = "Forms.RenameMoney.title";
    public const FORM_RENAME_MONEY_CONTENT = "Forms.RenameMoney.content";
    public const FORM_RENAME_MONEY_INPUT_1 = "Forms.RenameMoney.input1";
    public const FORM_RENAME_MONEY_INPUT_2 = "Forms.RenameMoney.input2";

    public const FORM_RENAME_XP_TITLE = "Forms.RenameXP.title";
    public const FORM_RENAME_XP_CONTENT = "Forms.RenameXP.content";
    public const FORM_RENAME_XP_INPUT_1 = "Forms.RenameXP.input1";
    public const FORM_RENAME_XP_INPUT_2 = "Forms.RenameXP.input2";

    public const FORM_LORE_MONEY_TITLE = "Forms.LoreMoney.title";
    public const FORM_LORE_MONEY_CONTENT = "Forms.LoreMoney.content";
    public const FORM_LORE_MONEY_INPUT_1 = "Forms.LoreMoney.input1";
    public const FORM_LORE_MONEY_INPUT_2 = "Forms.LoreMoney.input2";

    public const FORM_LORE_XP_TITLE = "Forms.LoreXP.title";
    public const FORM_LORE_XP_CONTENT = "Forms.LoreXP.content";
    public const FORM_LORE_XP_INPUT_1 = "Forms.LoreXP.input1";
    public const FORM_LORE_XP_INPUT_2 = "Forms.LoreXP.input2";

    public const FORM_COST_REPAIR_TITLE = "Forms.CostForm.Repair.title";
    public const FORM_COST_REPAIR_CONTENT = "Forms.CostForm.Repair.content";
    public const FORM_COST_REPAIR_BUTTON_MONEY = "Forms.CostForm.Repair.button-money";
    public const FORM_COST_REPAIR_BUTTON_XP = "Forms.CostForm.Repair.button-xp";
    public const FORM_COST_REPAIR_BUTTON_BACK = "Forms.CostForm.Repair.button-back";

    public const FORM_COST_RENAME_TITLE = "Forms.CostForm.Rename.title";
    public const FORM_COST_RENAME_CONTENT = "Forms.CostForm.Rename.content";
    public const FORM_COST_RENAME_BUTTON_MONEY = "Forms.CostForm.Rename.button-money";
    public const FORM_COST_RENAME_BUTTON_XP = "Forms.CostForm.Rename.button-xp";
    public const FORM_COST_RENAME_BUTTON_BACK = "Forms.CostForm.Rename.button-back";

    public const FORM_COST_LORE_TITLE = "Forms.CostForm.Lore.title";
    public const FORM_COST_LORE_CONTENT = "Forms.CostForm.Lore.content";
    public const FORM_COST_LORE_BUTTON_MONEY = "Forms.CostForm.Lore.button-money";
    public const FORM_COST_LORE_BUTTON_XP = "Forms.CostForm.Lore.button-xp";
    public const FORM_COST_LORE_BUTTON_BACK = "Forms.CostForm.Lore.button-back";

}