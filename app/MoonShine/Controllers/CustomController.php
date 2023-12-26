<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use MoonShine\MoonShineRequest;
use MoonShine\Http\Controllers\MoonShineController;
use Symfony\Component\HttpFoundation\Response;

final class CustomController extends MoonShineController
{
    public function __invoke(MoonShineRequest $request)
    {
        $productName = $request->input('name');
        $product = new Product();
        $product->name = $productName;
        $product->save();
        if ($images = $request->file()) {
            $images = $images['images'];
            /** @var UploadedFile $image */
            foreach ($images as $image) {
                $path = public_path('images/');
                !is_dir($path) &&
                mkdir($path, 0777, true);

                $imageName = time() . '.' . $image->extension();
                $image->move($path, $imageName);

                $image = new Image();
                $image->path = $imageName;
                $image->product_id = $product->id;
                $image->save();

                return back();
            }
        }

    }
}
