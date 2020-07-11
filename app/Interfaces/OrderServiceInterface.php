<?php

namespace App\Interfaces;

interface OrderServiceInterface
{
    public function getOrderCheck($conditions);
    public function create($data);
    public function getImageOrder($data);
    public function updateOrder($data);
    public function confirmOrder($data);
    public function checkBarcode($data);
    public function import($data);
    public function findWaybillCode($data);
    public function getOrderBeingTransportedStatus();
}
