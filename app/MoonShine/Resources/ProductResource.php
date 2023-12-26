<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\MoonShine\Pages\Product\ProductIndexPage;
use App\MoonShine\Pages\Product\ProductFormPage;
use App\MoonShine\Pages\Product\ProductDetailPage;

use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Products';

    public function pages(): array
    {
        return [
            ProductIndexPage::make($this->title()),
            ProductFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            ProductDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function fields(): array
    {
        return [
            HasMany::make('Images', 'images', null, new ImageResource())->creatable(),
            Text::make('name', 'name')
        ];
    }
}
