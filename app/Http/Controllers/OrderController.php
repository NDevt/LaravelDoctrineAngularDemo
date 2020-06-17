<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{

    private $orders;

    function __construct(OrderRepositoryInterface $orders)
    {
        $this->orders = $orders;
    }

    public function getOrders(Request $request)
    {
        try {
            $page = (int) $request->query('page');
        } catch (\Exception $e) {
            $page = 0;
        }

        if($page < 0) $page = 0;

        $length = 10;
        $data = $this->orders->getPage($page * $length, $length);
        $length = $this->orders->getCount();
        return response(['data' => $data, 'count' => $length], 200, ['content-type' => 'application/json']);
    }

    public function cancelOrder(Request $request, int $id)
    {
        $this->orders->cancelOrder($id);
        return response(['success' => true], 200, ['content-type' => 'application/json']);
    }

    public function index()
    {
        return File::get(public_path() . '/ng/index.html');
    }
}
