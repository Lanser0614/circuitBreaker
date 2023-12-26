<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\MoonShine\Pages\Image\ImageIndexPage;
use App\MoonShine\Pages\Image\ImageFormPage;
use App\MoonShine\Pages\Image\ImageDetailPage;

use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Resources\ModelResource;

class ImageResource extends ModelResource
{
    protected string $model = Image::class;

    protected string $title = 'Images';

    public function pages(): array
    {
        return [
            ImageIndexPage::make($this->title()),
            ImageFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            ImageDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

   public function fields(): array
   {
       return [
           BelongsTo::make('Product', 'product'),
           \MoonShine\Fields\Image::make('path')->removable()

//           \MoonShine\Fields\Image::make('path')->multiple(),
       ];
   }
}
