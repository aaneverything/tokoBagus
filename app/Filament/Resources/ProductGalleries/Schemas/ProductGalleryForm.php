<?php

namespace App\Filament\Resources\ProductGalleries\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ProductGalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('products_id')
                    ->label('Product')
                    ->options(Product::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                FileUpload::make('url')
                    ->label('Image')
                    ->image()
                    ->directory('product-galleries')
                    ->required(),
            ]);
    }
}
