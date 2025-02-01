<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Determina se o usuário pode visualizar um livro.
     */
    public function view(User $user, Book $book)
    {
        return in_array($user->role, ['admin', 'bibliotecario', 'cliente']);
    }

    /**
     * Determina se o usuário pode criar um livro.
     */
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'bibliotecario']);
    }

    /**
     * Determina se o usuário pode editar um livro.
     */
    public function update(User $user, Book $book)
    {
        return in_array($user->role, ['admin', 'bibliotecario']);
    }

    /**
     * Determina se o usuário pode excluir um livro.
     */
    public function delete(User $user, Book $book)
    {
        return $user->role === 'admin'; // Somente admin pode excluir
    }
}