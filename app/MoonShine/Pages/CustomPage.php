<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Image;
use MoonShine\Fields\Text;
use MoonShine\Pages\Page;

class CustomPage extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'CustomPage';
    }

    public function components(): array
	{
		return [
            Block::make([
                FormBuilder::make(route('custom.store'), 'POST')
                ->fields([
                    Text::make('Product name', 'name'),
                    Image::make('images', 'images')->multiple()
                ])
                ->name('main-form')
            ]),
            TableBuilder::make()
            ->fields([
                Text::make('Title')
            ])
        ];
	}
}
