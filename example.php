<?php
declare(strict_types=1);

namespace App;

use App\ModFilterPipeline\ModFilterPipeline;
use App\ModFilterPipeline\Stages\ExampleArrayStage;
use App\ModFilterPipeline\Stages\ExampleBoolStage;

// example of classes - use your own
$object1 = new ObjectBool();
$object2 = new ObjectBool();
$object3 = new ObjectArray();

$modFilterPipeline = (new ModFilterPipeline())
    ->pipeInitial(
        ExampleBoolStage::class,
        $object1->isActive(),
    )
    ->pipeInitial(
        ExampleBoolStage::class,
        $object2->isActive(),
    )
    ->pipeInitial(
        ExampleArrayStage::class,
        $object3->getArrayValues(),
    )
;

// do some changes here ...
$object1->updateActivity();
$object2->updateActivity();
$object2->updateArrayValues();

$modFilterPipeline
    ->pipeChanged(
        ExampleBoolStage::class,
        $object1->isActive(),
    )
    ->pipeChanged(
        ExampleBoolStage::class,
        $object2->isActive(),
    )
    ->pipeChanged(
        ExampleArrayStage::class,
        $object3->getArrayValues(),
    )
    ->process()
;

if ($modFilterPipeline->isChanged()) {
    // do need changes
}
