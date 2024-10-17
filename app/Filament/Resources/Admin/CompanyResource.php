<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\CompanyResource\Pages;
use App\Models\Company;
use App\Services\Datatables\ListActionService;
use App\Services\Datatables\ListFilterService;
use App\Services\Datatables\ListService;
use App\Services\FormSchema\FormFieldService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationGroup = 'Vehicles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldService::getTextField('company_name', 'Company', 100, true, true),
                        FormFieldService::getStatusField(),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ListService::getCommonTextColumn('company_name', 'Company'),
                ListService::getStatusDisplay('status'),
            ])
            ->filters([
                ListFilterService::getStatusFilter(),
            ])
            ->actions([
                ListActionService::getEditAction(),
                ListActionService::getDeleteAction(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
