<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        
        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->input('category') . '%');
        }

        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->input('author') . '%');
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->input('price'));
        }

        $books = $query->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        return view('books.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès.');
    }

    public function edit(Book $book)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Livre mis à jour avec succès.');
    }

    public function destroy(Book $book)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livre archivé avec succès.');
    }

    public function archived()
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $books = Book::onlyTrashed()->get();

        return view('books.archived', compact('books'));
    }

    public function forceDelete($id)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $book = Book::onlyTrashed()->findOrFail($id);

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->forceDelete();

        return redirect()->route('books.archived')->with('success', 'Livre supprimé définitivement avec succès.');
    }

    public function restore($id)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();

        return redirect()->route('books.archived')->with('success', 'Livre restauré avec succès.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
