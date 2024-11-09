<?php
declare(strict_types=1);

namespace App\ModFilterPipeline;

class ModFilterPipeline
{
    private array $stages = [];
    private array $conditions = [];
    private array $bind = [];
    private bool $changed = false;

    public function pipeInitial(string $stageClassName, mixed $value): self
    {
        $stage = new $stageClassName();
        $this->stages[$stage::class] = $stage->addInitial($value);

        return $this;
    }

    public function pipeChanged(string $stageClassName, mixed $value): self
    {
        if (null !== $stage = $this->stages[$stageClassName]) {
            $this->stages[$stageClassName] = $stage->addChanged($value);
        }

        return $this;
    }

    public function process(): void
    {
        foreach ($this->stages as $stage) {
            $needRequestAll = $stage->process($this);
            if ($needRequestAll) {
                break;
            }
        }
    }

    public function clearConditions(): self
    {
        $this
            ->setConditions([])
            ->setBind([])
        ;

        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function addCondition(string $condition): self
    {
        $this->conditions[] = $condition;

        return $this;
    }

    public function getBind(): array
    {
        return $this->bind;
    }

    public function setBind(array $bind): self
    {
        $this->bind = $bind;

        return $this;
    }

    public function addBind(string $key, mixed $value): self
    {
        $this->bind[$key] = $value;

        return $this;
    }

    public function isChanged(): bool
    {
        return $this->changed;
    }

    public function setChanged(bool $changed): self
    {
        $this->changed = $changed;

        return $this;
    }
}
