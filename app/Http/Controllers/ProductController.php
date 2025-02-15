<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ProductRepositoryInterface;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function index(): View
    {
        // TODO:: improve with a presenter
        return view('products.index', [
            'products' => $this->productRepository->orderBy('quantity', 'desc'),
        ]);
    }
}
