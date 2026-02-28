<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product_Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Textarea::make('description')
                    ->rows(3)
                    ->nullable(),
                TextInput::make('tags')
                    ->nullable(),
                Select::make('categories_id')
                    ->label('Category')
                    ->options(Product_Category::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
            ]);
    }
}

