<?php
namespace App\Repositories;

use App\Entities\Order;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository implements OrderRepositoryInterface
{

    public function getPage(int $start = 0, int $count = 10): ?array
    {
        return $this->findBy([], [], $count, $start);
    }

    public function getCount(): int
    {
        return $this->count([]);
    }

    public function cancelOrder(int $orderId): void
    {
        // TODO: Implement cancelOrder() method.
    }

    public function save(Order $order): int
    {
        $em = $this->getEntityManager();
        $em->persist($order);
        $em->flush();
        return $order->getId();
    }
}
