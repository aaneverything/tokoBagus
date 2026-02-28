<?php

namespace App\Filament\Resources\ProductGalleries\Pages;

use App\Filament\Resources\ProductGalleries\ProductGalleryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductGallery extends CreateRecord
{
    protected static string $resource = ProductGalleryResource::class;
}
