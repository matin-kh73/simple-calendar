<?php


namespace App\Presenters\Event;


use App\Models\Event;
use App\Presenters\contracts\Presenter;
use http\Exception\UnexpectedValueException;

class EventPresenter extends Presenter
{
    /**
     *
     * @return string
     */
    public function status()
    {
        switch ($this->entity->status){
            case Event::STATUS[0] :
                return 'todo';
            case Event::STATUS[1] :
                return 'done';
            default :
                throw new UnexpectedValueException('status of event is not valid!');
        }
    }
}
