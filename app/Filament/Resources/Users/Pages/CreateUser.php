<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\Users\UserResource;
use App\Notifications\WelcomeNewUserNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    private string $temporaryPassword;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        $allowedRoles = match ($user?->role) {
            UserRole::SuperAdmin => [
                UserRole::Owner->value,
            ],
            UserRole::Owner => [
                UserRole::PropertyManager->value,
                UserRole::Accountant->value,
                UserRole::Tenant->value,
            ],
            UserRole::PropertyManager => [
                UserRole::Tenant->value,
            ],
            default => [],
        };

        if ($allowedRoles === []) {
            throw new AuthorizationException('You are not allowed to create users.');
        }

        if (! in_array($data['role'] ?? null, $allowedRoles, true)) {
            $data['role'] = $allowedRoles[0];
        }

        $this->temporaryPassword = Str::password(12, symbols: false);

        $data['password'] = $this->temporaryPassword;
        $data['must_reset_password'] = true;

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->notify(new WelcomeNewUserNotification($this->temporaryPassword));
    }
}
