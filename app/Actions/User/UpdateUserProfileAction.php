<?php

namespace App\Actions\User;

use App\Models\User;

class UpdateUserProfileAction
{
    public function execute(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'telefone' => $data['telefone'] ?? null,
            'cpf' => $data['cpf'] ?? null,
        ]);

        return $user;
    }
}
