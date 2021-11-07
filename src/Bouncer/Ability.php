<?php

namespace Modules\Admin\src\Bouncer;

use Application;

class Ability implements IAbility
{
    private object $model;
    private object $abilities;

    public function __construct($model)
    {
        $this->model = $model;
        $this->abilities = $this->model->getAbilities();
    }

    public function getEntityAbilities($entity, $class, $module): ?array
    {
        if (!class_exists($entity)) {
            return null;
        }
        $model = ucfirst($class);
        $entity_type = "Modules\\$module\\Entities\\$model";
        $entityType = $entity_type;
        if ($model == 'Role') {
            $entityType = 'roles';
        }
        return [$entity_type, $this->abilities->where('entity_type', $entityType)];
    }

    public function setCrudFormAbilities($entity, $class, $module): array
    {
        list($model, $abilities) = $this->getEntityAbilities($entity, $class, $module);
        $crudList = ['index', 'create', 'show', 'edit', 'delete'];
        $crudData = [];
        foreach ($crudList as $value) {
            $crudData[$value] = $abilities->contains('name', $value);
        }
        return [$model, $crudData];
    }

    public function getModuleJsonAbilities($module): array
    {
        $attributes = $module->json()->getAttributes();
        if (!isset($attributes['abilities'])) {
            return [];
        }
        $data = [];
        foreach ($attributes['abilities'] as $classNamespace) {
            $class = explode('\\', $classNamespace);
            $class = end($class);
            $classSnake = explode('_', pascal_to_snake($class))[0];
            list($model, $crud) = $this->setCrudFormAbilities($classNamespace, $classSnake, $module);
            $data[$classNamespace] = [
                'translation' => $classSnake,
                'crud' => $crud,
                'model' => $model
            ];
        }
        return $data;
    }

    public function getModulesAbilities(): array
    {
        $modules = resolve('ActiveModules');
        $modulesAbilities = [];
        foreach ($modules as $module) {
            $moduleAbilities = $this->getModuleJsonAbilities($module);
            if (count($moduleAbilities)) {
                $modulesAbilities[$module->getName()] = $moduleAbilities;
            }
        }
        return $modulesAbilities;
    }
}
