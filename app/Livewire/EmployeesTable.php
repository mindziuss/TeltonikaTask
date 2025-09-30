<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Company;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
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

class EmployeesTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public Employee $employee;
    
    public function table(Table $table): Table
    {
        $company = Auth::guard('company')->user();

        return $table
            ->query(Employee::query()->where('company_id', $company->id))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('surname'),
                TextColumn::make('email'),
                TextColumn::make('phone'),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([
                $this->updateEmployeeData(),
                $this->deleteEmployee(),
            ])
            ->toolbarActions([
                // ...
            ])
            ->headerActions([
                $this->addEmployee($company),
            ]);
    }
    
    public function render(): View
    {
        return view('livewire.employees-table');
    }

    public function updateEmployeeData(): EditAction
    {
        return EditAction::make('edit')
                    ->label('Edit')
                    ->successNotificationTitle('Employee updated successfully')
                    ->button()
                    ->form([
                        TextInput::make('name')
                            ->label('Employee Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('surname')
                            ->label('Employee Surname')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->unique(table: Employee::class)
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Employee Phone Number')
                            ->required()
                            ->maxLength(255)
                            ->tel()
                            ->unique(table: Employee::class),
                    ])->action(function (Employee $record, array $data) {
                        $record->update($data);
                    });
    }

    public function deleteEmployee(): DeleteAction
    {
        return  DeleteAction::make('remove')
                    ->label('Remove')
                    ->button()
                    ->successNotificationTitle('Employee removed successfully')
                    ->action(function(Employee $record) {
                        $record->delete();
                    });
    }

    public function addEmployee(Company $company): CreateAction
    {
        return CreateAction::make('create')
                    ->label('Add Employee')
                    ->button()
                    ->successNotificationTitle('Employee added successfully')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('surname')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(table: Employee::class),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->unique(table: Employee::class),
                    ])
                    ->action(function(array $data) use ($company) {
                        $company->employees()->create($data);
                    });
    }
}
