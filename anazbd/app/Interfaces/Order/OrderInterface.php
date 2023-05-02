<?php


namespace App\Interfaces\Order;
use App\Models\Order;
use Illuminate\Http\Request;

interface OrderInterface
{
    public function index(Request $request);

    public function show(Order $order);

    public function edit(Order $order);

    function update(Request $request, Order $order);

    function delete(Order $order);

}
