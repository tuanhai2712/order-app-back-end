<?php

namespace App\Interfaces;

interface UserServiceInterface
{
    public function getUser($conditions);
    public function updatePriceListForUser($data);
}
