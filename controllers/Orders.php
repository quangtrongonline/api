<?php namespace Octommerce\API\Controllers;

use Auth;
use Octommerce\Octommerce\Models\Order;
use Octobro\API\Classes\ApiController;
use Octommerce\Octommerce\Classes\OrderManager;
use Octommerce\API\Transformers\OrderTransformer;

class Orders extends ApiController
{

	public function index()
    {
        return $this->respondwithCollection($this->user->orders, new OrderTransformer);

    }

    public function store()
    {
        $orderManager = OrderManager::instance();

        Auth::login($this->user);

        $order = $orderManager->create($this->data);

        return $this->respondwithItem($order, new OrderTransformer);
    }

    public function show($id)
    {
        $order = $this->user->orders()->whereId($id)->first();

        return $this->respondwithItem($order, new OrderTransformer);
    }

    public function update($id)
    {
        $order = $this->user->orders()->whereId($id)->first();

        $order->fill($this->data);
        $order->save();

        return $this->respondwithItem($order, new OrderTransformer);
    }
}
