<?php

namespace App\Livewire\Site\Pages;

use App\Enums\MessageTypeEnum;
use App\Enums\SortProductEnum;
use App\Models\BasketProduct;
use App\Models\Clothing;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Ramsey\Collection\Sort;

class Shop extends Component
{
    use WithPagination;

    #[Url]
    public $searchText;

    public $dir;

    public $sortColumn;

    #[Url]
    public $selectedSort;

    public $page;

    public $minPrice;
    public $maxPrice;

    public $sizes;
    public $colors;

    public $shopSizes = [];
    public $shopColors = [];

    public function mount()
    {
        $this->page = page()->getPage('shop');

        $this->sizes = Clothing::SIZES;
        $this->colors = Clothing::COLORS;

        $this->updatedSelectedSort();
    }

    public function updatedMinPrice()
    {
        if($this->maxPrice != null && $this->minPrice > $this->maxPrice)
            $this->minPrice = $this->maxPrice;
    }

    public function updatedMaxPrice()
    {
        if($this->minPrice != null && $this->minPrice > $this->maxPrice)
            $this->maxPrice = $this->minPrice;
    }

    public function updatedSelectedSort()
    {
        $selectedSort = SortProductEnum::tryFrom($this->selectedSort);

        $this->dir = $selectedSort?->sortDirection();
        $this->sortColumn = $selectedSort?->sortColumn();
    }

    public function updatedSearchText($value)
    {
        $this->resetPage();
    }

    public function redirectToProduct(Product $product)
    {
        return redirect()->route('products.show', $product);
    }

    #[On('basketProductRemoved')]
    public function updateBasketProducts()
    {
        $this->basketProducts = basket()->getBasketProducts();
    }


    public function addToBasket(Product $product)
    {
        if(basket()->set($product))
        {
            $this->dispatch('showPopup', 'Додано до корзини', MessageTypeEnum::INFORMATION, 2000);
        } else {
            $this->dispatch('showPopup', 'Товар закінчився', MessageTypeEnum::INFORMATION, 2000);
        }

        $this->dispatch('basketUpdated');
    }

    public function searchQuery(Builder $builder)
    {
        $builder->search($this->searchText);
    }

    public function priceQuery(Builder $builder)
    {
        $minPrice = $this->minPrice;
        $maxPrice = $this->maxPrice;

        if(!$minPrice)
            $minPrice = 0;

        if(!$maxPrice)
            $maxPrice = Product::max('price');

        $builder->priceBetween((int)($minPrice * 100), (int)($maxPrice * 100));
    }

    public function sizeQuery(Builder $builder)
    {
        if (!empty($this->shopSizes)) {
            $builder->bySizes($this->shopSizes);
        }
    }

    public function colorQuery(Builder $builder)
    {
        if (!empty($this->shopColors)) {
            $builder->byColors($this->shopColors);
        }
    }

    public function sortQuery(Builder $builder)
    {
        if(!isset($this->dir) || !isset($this->sortColumn))
            return;

        $builder->sort($this->sortColumn, $this->dir);
    }

    public function loadRelations(Builder $builder)
    {
        $builder->with('availableSizes', 'firstPhoto', 'clothing');
    }

    public function products()
    {
        $builder = Product::query();

        $builder->available();

        $this->searchQuery($builder);
        $this->priceQuery($builder);
        $this->sizeQuery($builder);
        $this->colorQuery($builder);
        $this->sortQuery($builder);

        $this->loadRelations($builder);

        $builder->groupBy('name');

        return $builder->paginate(25);
    }

    public function render()
    {
        return view('livewire.site.pages.shop', [ 'products' => $this->products()])
            ->layout('components.layouts.app');
    }
}
