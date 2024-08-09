<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\HtmlString;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_transaksi')
                ->label('Kode Transaksi')
                ->required(),

                Select::make('jenis_transaksi')
                ->options([
                    '0' => 'Pengeluaran',
                    '1' => 'Pemasukan'
                ])
                ->label('Jenis Transaksi')
                ->required(),

                TextInput::make('atas_nama')
                ->label('Atas Nama')
                ->required(),

                TextInput::make('jumlah')
                ->numeric()
                ->Label('Nominal Transaksi')
                ->required(),

                TextInput::make('keterangan')
                ->label('Deskripsi')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_transaksi'),
                TextColumn::make('jenis_transaksi')
                ->formatStateUsing(function ($state) {
                    if ($state == '0') {
                        return new HtmlString('<span style="color: red;"><x-heroicon-o-arrow-down-circle class="w-5 h-5 inline" /> Pengeluaran</span>');
                    } else {
                        return new HtmlString('<span style="color: green;"><x-heroicon-o-arrow-up-circle class="w-5 h-5 inline" /> Pemasukan</span>');
                    }
                }),
                TextColumn::make('atas_nama'),
                TextColumn::make('jumlah'),
                TextColumn::make('keterangan'),
            ])
            ->filters([
                SelectFilter::make('jenis_transaksi')
                ->options([
                    '0' => 'Pengeluaran',
                    '1' => 'Pemasukan',
                ])
                
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
