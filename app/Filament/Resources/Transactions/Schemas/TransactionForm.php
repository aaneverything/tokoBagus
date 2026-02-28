<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('users_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Textarea::make('address')
                    ->label('Address')
                    ->rows(3)
                    ->nullable(),
                Select::make('payment')
                    ->options([
                        'manual' => 'Manual',
                    ])
                    ->default('manual')
                    ->native(false),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'shipping' => 'Shipping',
                        'success' => 'Success',
                        'canceled' => 'Canceled',
                        'failed' => 'Failed',
                        'shipped' => 'Shipped',
                    ])
                    ->default('pending')
                    ->native(false),
                TextInput::make('shipping_price')
                    ->label('Shipping Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->default(0),
                TextInput::make('total_price')
                    ->label('Total Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->default(0),
            ]);
    }
}

