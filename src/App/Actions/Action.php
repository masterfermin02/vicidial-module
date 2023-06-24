<?php

namespace App\Actions;

interface Action
{
    public function execute(array $params): void;
}
