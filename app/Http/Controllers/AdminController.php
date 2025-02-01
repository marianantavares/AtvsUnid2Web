<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Exibe a lista de usuários (somente administradores)
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::paginate(15); // Paginação para melhorar a performance
        return view('admin.users.index', compact('users'));
    }

    // Mostra o formulário para criar um novo usuário
    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    // Armazena um novo usuário
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso.');
    }

    // Exibe detalhes de um usuário específico
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    // Mostra o formulário para editar um usuário existente
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    // Atualiza os dados do usuário
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    // Remove um usuário do sistema
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Você não pode excluir sua própria conta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}