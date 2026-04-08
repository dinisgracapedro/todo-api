<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    // Cria um novo usuário no banco de dados
    public function create(array $data)
    {
        return User::create($data);
    }

    // Encontra um usuário pelo e-mail
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    // Encontra um usuário pelo ID
    public function findById(int $id)
    {
        return User::find($id);
    }

    // Deleta os tokens de um usuário
    public function deleteTokens(User $user)
    {
        $user->tokens()->delete();
    }
}