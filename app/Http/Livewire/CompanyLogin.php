<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Filament\Pages\CompanyDashboard;

class CompanyLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function mount(): void
    {
        if (Auth::guard('company')->check()) {
            redirect()->route('company.dashboard');
        }
    }

    public function login(): void
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('company')->attempt($credentials, $this->remember)) {
            session()->regenerate();
            redirect()->route('company.dashboard');
            return;
        }

        $this->addError('email', 'Invalid credentials.');
    }

    public function render()
    {
        return view('livewire.company-login')
            ->layout('components.layouts.company'); // <- your layout
    }
}
