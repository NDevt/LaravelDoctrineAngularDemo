<?php


namespace App\Repositories;


use App\Entities\Order;

interface OrderRepositoryInterface
{
    /**
     * @param int $start
     * @param int $count
     * @return array<Order>|null
     */
    public function getPage(int $start = 0, int $count = 10): ?array;
    public function getCount(): int;
    public function cancelOrder(int $orderId): void;
}
