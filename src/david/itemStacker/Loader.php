<?php

declare(strict_types=1);

namespace david\itemStacker;

use pocketmine\plugin\PluginBase;

use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;

class Loader extends PluginBase {

    protected function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        libPiggyUpdateChecker::init($this);
    }
}
