<?php
declare(strict_types=1);

namespace App\ModFilterPipeline\Stages;

use App\ModFilterPipeline\ModFilterPipeline;
use App\ModFilterPipeline\Interface\FilterPipelineStage;

class ExampleBoolStage implements FilterPipelineStage
{
    private ?bool $exampleValuePrev = null;
    private ?bool $exampleValue = null;

    public function process(ModFilterPipeline $modFilter): bool
    {
        if ($this->exampleValuePrev !== $this->exampleValue) {
            $modFilter
                ->setChanged(true)
                ->clearConditions()
            ;
            return true;
        }

        return false;
    }

    public function addInitial(mixed $value): self
    {
        $this->exampleValuePrev = $value;

        return $this;
    }

    public function addChanged(mixed $value): self
    {
        $this->exampleValue = $value;

        return $this;
    }
}
