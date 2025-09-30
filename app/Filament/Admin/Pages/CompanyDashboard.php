<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class CompanyDashboard extends Page
{
    public ?Company $company = null;

    protected string $view = 'filament.admin.pages.company-dashboard';

    // Custom layout
    // public function getLayout(): string
    // {
    //     return 'components.layouts.company';
    // }

    public function mount(): void
    {
        $this->company = Auth::guard('company')->user();

        if (!$this->company) {
            redirect()->route('company.login')->send();
        }
    }

    public static function getNavigationLabel(): string
    {
        return 'Company';
    }

    public function render(): View
    {
        return view($this->view, [
            'company' => $this->company,
        ])->layout($this->getLayout());
    }
}