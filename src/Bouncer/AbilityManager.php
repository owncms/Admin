<?php

namespace Modules\Admin\src\Bouncer;

class AbilityManager
{
    private object $ability;

    public function init($model): object
    {
        $this->ability = new Ability($model);
        return $this;
    }

    public function getModulesAbilities(): array
    {
        return $this->ability->getModulesAbilities();
    }
}
