<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.reset-password';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLockClosed;

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('current_password')
                    ->label('Temporary Password')
                    ->password()
                    ->required(),
                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->confirmed(),
                TextInput::make('password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Set New Password')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = auth()->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            $this->addError('data.current_password', 'The temporary password is incorrect.');

            return;
        }

        $user->update([
            'password' => $data['password'],
            'must_reset_password' => false,
        ]);

        Notification::make()
            ->title('Password updated successfully.')
            ->success()
            ->send();

        $this->redirect(route('filament.admin.pages.dashboard'));
    }
}
