<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
// use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;


class ProductSearch extends Component
{
    public $query = "";

    public $category = "";

    public $categories;

    use \Livewire\WithPagination; 

    public $page = 1;

    public function mount(): void{
        $this->categories = Category::all();
    }

    public function updatingQuery(): void{
        $this->resetPage();
    }

    public function updatingCategory(): void{
        $this->resetPage();
    }

    public function render(): View
    {
        $products = Product::query()
            ->when($this->query, function(Builder $query): void {
            $query->where('name', 'like', '%'. $this->query . '%');
        })->when($this->category, function (Builder $query): void {
            $query->where('category_id', $this->category);
        })->paginate(3);
        return view('livewire.product-search', compact('products'));
    }
}
