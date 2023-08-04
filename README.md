# RepairUI
[![](https://poggit.pmmp.io/shield.state/RepairUI)](https://poggit.pmmp.io/p/RepairUI)

[![](https://poggit.pmmp.io/shield.api/RepairUI)](https://poggit.pmmp.io/p/RepairUI)

**Repair and customize your item names with RepairUI, use money or experience to perform these actions. Only for PocketMine-MP 5.0 servers**

![Captura de pantalla 2022-06-29 174022](https://user-images.githubusercontent.com/83558341/176567746-9eda44e8-2ce8-4a36-9b84-eacf611e1385.png)

<a href="https://discord.gg/YyE9XFckqb"><img src="https://img.shields.io/discord/837701868649709568?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>

### 🌍 Wiki
* Check our plugin [wiki](https://github.com/fernanACM/RepairUI/wiki) for features and secrets in the...

### 💡 Implementations
* [x] Images > *To load the images, use [FormImagesFIX](https://poggit.pmmp.io/ci/VennDev/VFormImagesFix/VFormImagesFix)*
* [X] Configuration
* [X] Multilanguage
* [x] EconmyAPI & BedrockEconomy
* [x] Sounds
* [X] Commands
---

### 💾 Config
```yml
#  ____                           _          _   _   ___ 
# |  _ \    ___   _ __     __ _  (_)  _ __  | | | | |_ _|
# | |_) |  / _ \ | '_ \   / _` | | | | '__| | | | |  | | 
# |  _ <  |  __/ | |_) | | (_| | | | | |    | |_| |  | | 
# |_| \_\  \___| | .__/   \__,_| |_| |_|     \___/  |___|
#                |_|                                     
#           by fernanACM
# Repair and customize your item names with RepairUI, for PocketMine-MP 5.0 servers

# DO NOT TOUCH!
config-version: "1.0.0"
# Plugin prefix
Prefix: "&l&f[&dRepairUI&f]&8»&r "
# Languages
# "eng", // English
# "spa", // Spanish
# "ger", // German
# "indo", // Indonesian
# "vie" // Vietnamese
language: eng
# Usa economyapi, bedrockeconomy, xp
Economy: 
  provider: bedrockeconomy
# ==(SETTINGS)==
Settings:
  Use:
    # Use "true" or "false" to interact with the anvil
    anvil: true
  Commands:
    # Use "true" or "false" to run the command
    # RepairAll command; /repair all
    all: true
    # Use "true" or "false" to run the command
    # RepairHand command: /repair hand
    hand: true
    # Use "true" or "false" to run the command
    # RepairAll command; /repair rename <name>
    rename: true
    # Use "true" or "false" to run the command
    # RepairAll command; /repair lore <lore>
    lore: true

# ==(REPAIR COST)==
RepairCost:
  # Repair mode
  Repair:
    # Put the amount of money cost to repair the items
    money-cost: 30
    # Put the amount of experience cost to repair the items
    xp-cost: 10
    # Damage repair mode. The price will be multiplied by the damage of the item. 
    # IT IS RECOMMENDED TO PUT THE PRICE LOW IF THIS OPTION IS CURRENT.
    # Use "true" or "false" to enable/disable this option
    damage-mode: false
  # Lore mode
  Lore:
    # Put the amount of money cost to change the lore of the items
    money-cost: 60
    # Put the amount of experence cost to change the lore of the items
    xp-cost: 20
  # Rename mode
  Rename:
    # Put the amount of money cost to change the name of the items
    money-cost: 50
    # Put the amount of experence cost to change the name of the items
    xp-cost: 20
```

### 🕹 Commands
| Command | Description |
|---------|-------------|
| ```/repairui``` | Open the main menu |
| ```/repairui help``` | Command list |
| ```/repairui all``` | Repair all items |
| ```/repairui hand``` | Repair the items in your hand |
| ```/repairui rename``` | Rename the item in your hand |
| ```/repairui lore``` | Lore the item in your hand |

### 🔒 Permissions
| Permission | Description |
|---------|-------------|
| ```repairui.cmd.acm``` | Executing the command |
| ```repairui.help.acm``` | Command list |
| ```repairui.repair.all``` | Repair all command |
| ```repairui.repair.hand``` | Repair hand command |
| ```repairui.repair.money``` | Repair with money |
| ```repairui.repair.xp``` | Repair with xp |
| ```repairui.rename.money``` | Rename with money |
| ```repairui.rename.xp``` | Rename with xp |
| ```repairui.rename.cmd``` | Rename command |
| ```repairui.lore.money``` | Lore with money |
| ```repairui.lore.xp``` | Lore with xp |
| ```repairui.lore.cmd``` | Lore command |

### 🌐 MultiLanguage
| Language | Translated by |
|----------|---------------|
| English | [fernanACM](https://github.com/fernanACM) |
| Spanish | [fernanACM](https://github.com/fernanACM) |
| Indonesian | RepairUI |
| German | [GamerMJay](https://github.com/GamerMJay) |
| Vietnamese | [NhanAZ](https://github.com/NhanAZ) |

### 📢 Report bug
* If you find any bugs in this plugin, please let me know via: [issues](https://github.com/fernanACM/RepairUI/issues)

### 📞 Contact 
| Redes | Tag | Link |
|-------|-------------|------|
| YouTube | fernanACM | [YouTube](https://www.youtube.com/channel/UC-M5iTrCItYQBg5GMuX5ySw) | 
| Discord | fernanACM#5078 | [Discord](https://discord.gg/YyE9XFckqb) |
| GitHub | fernanACM | [GitHub](https://github.com/fernanACM)
| Poggit | fernanACM | [Poggit](https://poggit.pmmp.io/ci/fernanACM)
****

### ✔ Credits
| Authors | Github | Lib |
|---------|--------|-----|
| CortexPE | [CortexPE](https://github.com/CortexPE) | [Commando](https://github.com/CortexPE/Commando/tree/master/) |
| Muqsit | [Muqsit](https://github.com/Muqsit) | [SimplePacketHandler](https://github.com/Muqsit/SimplePacketHandler) |
| Vecnavium | [Vecnavium](https://github.com/Vecnavium) | [FormsUI](https://github.com/Vecnavium/FormsUI/tree/master/) |
| DaPigGuy | [DaPigGuy](https://github.com/DaPigGuy) | [libPiggyEconomy](https://github.com/DaPigGuy/libPiggyEconomy) |
| DaPigGuy | [DaPigGuy](https://github.com/DaPigGuy) | [libPiggyUpdateChecker](https://github.com/DaPigGuy/libPiggyUpdateChecker) |
