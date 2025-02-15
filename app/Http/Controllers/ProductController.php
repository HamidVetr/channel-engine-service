<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ProductRepositoryInterface;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly ChannelEngineServiceInterface $channelEngineService,
    ) {
    }

    public function index(): View
    {
        // TODO:: improve with a presenter
        return view('products.index', [
            'products' => $this->productRepository->orderBy('quantity', 'desc'),
        ]);
    }

    public function setStock(string $productId): RedirectResponse
    {
        $this->channelEngineService->setProductStock($productId, 25);

        return redirect()->route('products.index');
    }
}
