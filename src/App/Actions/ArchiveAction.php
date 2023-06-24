<?php

namespace App\Actions;

class ArchiveAction implements Action
{
    protected RemoveAction $removeAction;

    public function __construct(RemoveAction $removeAction)
    {
        $this->removeAction = $removeAction;
    }

    public function execute(array $params): void
    {
        $this->removeAction->remove($params['phone']);
    }

}
