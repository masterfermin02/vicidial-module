<?php

namespace App\Actions;

class AddedAction implements Action
{
    protected CreateAction $createAction;
    public function __construct(CreateAction $createAction)
    {
        $this->createAction = $createAction;
    }

    public function execute(array $params): void
    {
        $this->createAction->create($params);
    }
}
