<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components:[
                TextInput::make(name: 'name')->label(label: 'Nombre')->required()->placeholder(placeholder: 'Nombre del producto')->maxLength(length:100),
                TextInput::make(name: 'description')->label(label: 'Description')->required()->placeholder(placeholder: 'Descripcion del producto')->maxLength(length:255),
                TextInput::make(name: 'price')->label(label: 'Precio')->required()->placeholder(placeholder: 'Precio del producto')->prefix(label:'$')->numeric(),
                FileUpload::make(name: 'image')->label(label: 'Imagen')->required()->placeholder(placeholder: 'Imagen del producto')->image()->directory(directory: 'products'),
                Select::make(name: 'category_id')->label(label: 'Categoria del producto')->required()->relationship(name: 'category', titleAttribute: 'name')->placeholder(placeholder: 'Seleccione una categoria'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(components:[
                TextColumn::make(name: 'name')->label(label: 'Nombre')->searchable()->sortable(),
                TextColumn::make(name: 'description')->label(label: 'Description')->searchable()->sortable(),
                TextColumn::make(name: 'price')->label(label: 'Precio')->searchable()->prefix(prefix: '$')->formatStateUsing(callback: function(string $state): string{
                    return number_format(num: $state, decimals: 2, decimal_separator:',', thousands_separator:'.');
                })->sortable(),
                TextColumn::make(name: 'category.name')->label(label: 'Categoria')->searchable()->sortable(),
                ImageColumn::make(name: 'image')->label(label: 'Imagen')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
