<?php
declare(strict_types=1);

namespace App\ModFilterPipeline\Stages;

use App\ModFilterPipeline\ModFilterPipeline;
use App\ModFilterPipeline\Interface\FilterPipelineStage;

class ExampleArrayStage implements FilterPipelineStage
{
    private array $examplePrev = [];
    private array $example = [];

    public function process(ModFilterPipeline $modFilter): bool
    {
        if ($this->examplePrev === $this->example) {
            return false;
        }
        $modFilter->setChanged(true);

        $updatedExampleIds = [];
        foreach ($this->example as $key => $val) {
            if (!array_key_exists($key, $this->examplePrev) || $this->examplePrev[$key] !== $val) {
                $updatedExampleIds[] = $key;
            }
        }

        if (count($updatedExampleIds)) {
            $sql = 'SELECT ...';
            $modFilter
                ->addCondition($sql)
                ->addBind('exampleIds', $updatedExampleIds)
            ;
        }

        return false;
    }

    public function addInitial(mixed $value): self
    {
        if (is_array($value) && $value->count() > 0) {
            foreach ($value as $item) {
                $this->examplePrev[$item->getId()] = $item->fieldValue();
            }
        }

        return $this;
    }

    public function addChanged(mixed $value): self
    {
        if (is_array($value) && $value->count() > 0) {
            foreach ($value as $item) {
                $this->example[$item->getId()] = $item->fieldValue();
            }
        }

        return $this;
    }
}
