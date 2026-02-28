<?php

namespace App\Filament\Resources\ProductGalleries\Pages;

use App\Filament\Resources\ProductGalleries\ProductGalleryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductGalleries extends ListRecords
{
    protected static string $resource = ProductGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
