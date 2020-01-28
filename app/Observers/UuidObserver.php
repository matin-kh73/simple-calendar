<?php


namespace App\Observers;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UuidObserver
{

    /**
     * Listen to the Model creating event.
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */

    public function creating(Model $model)
    {
        $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
    }
}
