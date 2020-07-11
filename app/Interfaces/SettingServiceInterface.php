<?php

namespace App\Interfaces;

interface SettingServiceInterface
{
    public function setting($data);
    public function getSetting();
    public function getCustomers($role);
    public function getOverview($userId, $role);
}
