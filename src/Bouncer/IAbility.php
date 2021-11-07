<?php

namespace Modules\Admin\src\Bouncer;

interface IAbility
{
    public function getEntityAbilities($entity, $class, $module): ?array;

    public function setCrudFormAbilities($entity, $class, $module): array;

    public function getModuleJsonAbilities($module): array;

    public function getModulesAbilities(): array;
}
