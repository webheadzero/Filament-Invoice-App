<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\Action;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';    

    protected static ?string $navigationLabel = 'Invoices';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'company_name')
                    ->searchable()
                    ->required(),
                Grid::make(3)   
                ->schema([
                    TextInput::make('invoice_number')
                        ->disabled() 
                        ->default(fn () => 'Generating invoice number...'),
                    DatePicker::make('invoice_date')
                        ->default(now())
                        ->required(),
                    TextInput::make('total_amount')
                        ->required()
                        ->prefix('Rp')
                        ->numeric()
                        ->readOnly(),
                    
                ]),

                Repeater::make('items')
                    ->label('Invoice Items')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('description')
                            ->label('Item Description')
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->required()
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $quantity = floatval($state);
                                $unitPrice = floatval($get('unit_price'));
                                $totalPrice = $quantity * $unitPrice;
                                $set('total_price', $totalPrice);
                                
                                // Update total amount
                                $items = $get('../../items');
                                $total = 0;
                                foreach ($items as $item) {
                                    $total += floatval($item['total_price'] ?? 0);
                                }
                                $set('../../total_amount', $total);
                            }),
                        TextInput::make('unit_price')
                            ->label('Unit Price')
                            ->required()
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $unitPrice = floatval($state);
                                $quantity = floatval($get('quantity'));
                                $totalPrice = $quantity * $unitPrice;
                                $set('total_price', $totalPrice);
                                
                                // Update total amount
                                $items = $get('../../items');
                                $total = 0;
                                foreach ($items as $item) {
                                    $total += floatval($item['total_price'] ?? 0);
                                }
                                $set('../../total_amount', $total);
                            }),
                        TextInput::make('total_price')
                            ->label('Total Price')
                            ->disabled()
                            ->numeric()
                            ->dehydrated(true),
                    ])
                    ->columns(4)
                    ->minItems(1)
                    ->maxItems(10)
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $items = $get('items');
                        $total = 0;
                        foreach ($items as $item) {
                            $total += floatval($item['total_price'] ?? 0);
                        }
                        $set('total_amount', $total);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client.company_name')
                    ->label('Client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->color('gray'),
                Tables\Actions\EditAction::make()->label('')->color('gray'),
                Tables\Actions\DeleteAction::make()->label('')->color('gray'),
                Action::make('print')
                    ->label('')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Invoice $record): string => route('invoices.print', ['invoice' => $record]))
                    ->openUrlInNewTab()
                    ->color('gray'),
                Action::make('download')
                    ->label('')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Invoice $record): string => route('invoices.download', ['invoice' => $record]))
                    ->color('gray'),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'view' => Pages\ViewInvoice::route('/{record}'),
        ];
    }
}
