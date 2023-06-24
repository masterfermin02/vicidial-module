<?php

namespace App\Actions;

interface RemoveAction
{
    public function remove(string $phone): void;
}
