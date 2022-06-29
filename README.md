# RepairUI
[![](https://poggit.pmmp.io/shield.state/RepairUI)](https://poggit.pmmp.io/p/RepairUI)

[![](https://poggit.pmmp.io/shield.api/RepairUI)](https://poggit.pmmp.io/p/RepairUI)

**Repair and customize your item names with RepairUI, use money or experience to perform these actions. Only for PocketMine-MP 4.0 servers**

<a href="https://discord.gg/YyE9XFckqb"><img src="https://img.shields.io/discord/837701868649709568?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>

### 💡 Implementations
* [x] Images > *To load the images, use [FormImagesFIX](https://poggit.pmmp.io/r/146450/FormImagesFix_dev-14.phar)*
* [X] Configuration
* [x] Sounds.
* [x] Message customization.
* [X] Commands.
* [x] Keys in messages.yml.
---

### 💾 Config
```yml
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

   # Repair and customize your item names with RepairUI, for PocketMine-MP 4.0 servers

   # =======(SETTINGS)=======
   # Use "true" or "false" to interact with the anvil
   Use:
     Anvil: true
     # Use "true" or "false" to run the command
   Commands:
     # RepairAll command </repair all>
     all: true
     # RepairHand command </repair hand>
     hand: true

   RepairCost:
    # RepairUI
    Repair:
      # Put the amount of money cost to repair the items
      # SMALL NUMBERS RECOMMENDED!!
      Money: 30
      # Put the amount of experience cost to repair the items
      # SMALL NUMBERS RECOMMENDED!!
      XP: 10

    # RenameUI
    Rename:
      # Put the amount of money cost to change the name of the items
      Money: 50
      # Put the amount of experence cost to change the name of the items
      XP: 20

    # LoreUI
    Lore:
      # Put the amount of money cost to change the lore of the items
      Money: 60
      # Put the amount of experience cost to change the lore of the items
      XP: 20
```
### 🕹 Commands
- ```/repairui``` > Open a menu for convenience
- ```/repairui help``` > Command list
- ```/repairui hand``` > Repair all your items at your fingertips
- ```/repairui all``` > Repair the items in your hand

### 🔒 Permissions
- Executing the command: ```repairui.cmd.acm```
- Command list: ```repairui.help.acm```
- RepairAll: ```repairui.repair.all```
- RepairHand: ```repairui.repair.hand```
- RepairMoney: ```repairui.repair.money```
- RepairXP: ```repairui.repair.xp```
- RenameMoney: ```repairui.rename.money```
- RenameXP: ```repairui.rename.xp```
- LoreMoney: ```repairui.lore.money```
- LoreXP: ```repairui.lore.xp```

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
| Vecnavium | [Vecnavium](https://github.com/Vecnavium) | FormsUI](https://github.com/Vecnavium/FormsUI/tree/master/) |
| David-pm-pl | [David-pm-pl](https://github.com/David-pm-pl) | [LibEco](https://github.com/David-pm-pl/libEco) |
****
