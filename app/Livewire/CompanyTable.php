<?php

namespace App\Livewire;

use App\Models\Company;
use Filament\Actions\EditAction;
use Filament\Actions\Concerns\InteractsWithActions;  
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Livewire\Component;

class CompanyTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public $company = null;
    
    public function table(Table $table): Table
    {
        $this->company = Auth::guard('company')->user();

        return $table
            ->query(Company::query()->where('id', $this->company->id))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('url'),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([ 
                $this->editCompanyData(),
            ])
            ->toolbarActions([
                // ...
            ]);
    }
    
    public function render(): View
    {
        return view('livewire.company-table');
    }

    public function editCompanyData(): EditAction
    {
        return  EditAction::make('edit')
                    ->label('Edit')
                    ->button()
                    ->successNotificationTitle('Company updated successfully')
                    ->form([
                        TextInput::make('name')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->unique(table: Company::class)
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('url')
                            ->label('Company Website')
                            ->required()
                            ->maxLength(255)
                            ->url(),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->minLength(8)
                            ->maxLength(255)
                            ->confirmed()
                            ->dehydrated(fn($state) => filled($state)),
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->dehydrated(false),
                    ])
                    ->action(function (Company $record, array $data) {
                        if (!empty($data['password'])) {
                            $data['password'] = bcrypt($data['password']);
                        } else {
                            unset($data['password']);
                        }

                        $record->update($data);
                    });
    }
}
