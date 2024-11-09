<?php
declare(strict_types=1);

namespace App\ModFilterPipeline\Interface;

use App\ModFilterPipeline\ModFilterPipeline;

interface FilterPipelineStage
{
    public function addInitial(mixed $value);

    public function addChanged(mixed $value);

    public function process(ModFilterPipeline $modFilter): bool;
}
