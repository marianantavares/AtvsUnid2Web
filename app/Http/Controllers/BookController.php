<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;

class BookController extends Controller
{
    /**
     * Exibe a lista de livros.
     */
    public function index()
    {
        $books = Book::with('author')->paginate(20);
        return view('books.index', compact('books'));
    }

    /**
     * Exibe os detalhes de um livro.
     */
    public function show(Book $book)
    {
        // Qualquer usuário pode visualizar
        $this->authorize('view', $book);

        $book->load(['author', 'publisher', 'category']);
        $users = User::all();
        return view('books.show', compact('book', 'users'));
    }

    /**
     * Exibe o formulário de criação (com ID manual).
     */
    public function createWithId()
    {
        // Apenas admin e bibliotecário podem criar
        $this->authorize('create', Book::class); 

        return view('books.create-id');
    }

    /**
     * Salva um livro inserindo IDs manualmente.
     */
    public function storeWithId(Request $request)
    {
        $this->authorize('create', Book::class); 

        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    /**
     * Exibe o formulário de criação (com selects).
     */
    public function createWithSelect()
    {
        $this->authorize('create', Book::class); 

        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    /**
     * Salva um livro usando selects.
     */
    public function storeWithSelect(Request $request)
    {
        $this->authorize('create', Book::class); 

        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        Book::create($request->all());
        
        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(Book $book)
    {
        $this->authorize('update', $book); 

        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();
        
        return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }

    /**
     * Atualiza um livro.
     */
    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book); 

        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * Remove um livro.
     */
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso.');
    }
}