<?php

namespace App\Filament\Resources\ProductGalleries\Pages;

use App\Filament\Resources\ProductGalleries\ProductGalleryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditProductGallery extends EditRecord
{
    protected static string $resource = ProductGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
