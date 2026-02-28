<?php

namespace App\Filament\Resources\ProductGalleries;

use App\Filament\Resources\ProductGalleries\Pages\CreateProductGallery;
use App\Filament\Resources\ProductGalleries\Pages\EditProductGallery;
use App\Filament\Resources\ProductGalleries\Pages\ListProductGalleries;
use App\Filament\Resources\ProductGalleries\Schemas\ProductGalleryForm;
use App\Filament\Resources\ProductGalleries\Tables\ProductGalleriesTable;
use App\Models\Product_gallery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductGalleryResource extends Resource
{
    protected static ?string $model = Product_gallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Galleries';

    protected static string|\UnitEnum|null $navigationGroup = 'Products';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ProductGalleryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductGalleriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductGalleries::route('/'),
            'create' => CreateProductGallery::route('/create'),
            'edit' => EditProductGallery::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
