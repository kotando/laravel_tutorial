<?php

namespace App\Http\Controllers;

use App\Services\ShopService;

use App\Http\Requests\Shop\StoreRequest;
use App\Http\Requests\Shop\UpdateRequest;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function index()
    {
        $shops = $this->shopService->index();
        return view('shop.index', compact('shops'));
    }

    public function create()
    {
        return view('shop.create');
    }

    public function store(StoreRequest $request)
    {
        $input = [
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
        ];

        $this->shopService->create($inputs);
        return redirect()->route('shop.index');
    }

    public function edit(int $shopId)
    {
        //try ~ catch
        try {
            $shop = $this->shopService->findOrFail($shopId);
        } catch(ModuleNotFoundException $e) {
            return response()->view('errors.404');
        };

        return view('shop.edit', compact('shop'));
    }

    public function update(UpdateRequest $request, int $shopId)
    {
        $inputs = [
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id')
        ];

        $shop = $this->shopService->findOrFail($shopId);
        $this->shopService->update($shop, $inputs);

        return redirect()->route('shop.index');
    }

    public function destroy(int $shopId)
    {
        $shop = $this->shopService->findOrFail($shopId);
        $this->shopService->delete($shop);
    }

}
