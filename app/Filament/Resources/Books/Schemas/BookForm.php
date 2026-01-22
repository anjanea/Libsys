<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;


class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('author')
                    ->required()
                    ->maxLength(255),

                TextInput::make('isbn')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(20),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('publisher')
                    ->maxLength(255),

                TextInput::make('publication_year')
                    ->numeric()
                    ->minValue(1000)
                    ->maxValue(date('Y')),

                Textarea::make('description')
                    ->columnSpanFull(),

                FileUpload::make('cover_path')
                    ->disk('public')
                    ->directory('books/covers')
                    ->image()
                    ->imageEditor(),

               TextInput::make('total_copies')
                ->numeric()
                ->required()
                ->default(1)
                ->minValue(1),

               TextInput::make('available_copies')
                ->numeric()
                ->required()
                ->default(1)
                ->minValue(0)
                // Kita gunakan validasi standar Laravel: ketersediaan tidak boleh lebih dari total stok
                ->rule(static function ($get) {
                    return "max:{$get('total_copies')}";
                })
                ->validationMessages([
                    'max' => 'Buku tersedia tidak boleh melebihi total stok.',
                ]),

                Toggle::make('is_active')
                    ->label('Tampilkan di Katalog')
                    ->default(true),
            ]);
    }
}