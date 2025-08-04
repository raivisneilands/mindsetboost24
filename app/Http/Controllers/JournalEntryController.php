<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function index()
    {
        $entries = auth()->user()->journalEntries()->latest()->get();
        return view('journal.index', compact('entries'));
    }

    public function create()
    {
        return view('journal.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        auth()->user()->journalEntries()->create([
            'title' => $data['title'],
            'body' => $data['body'],
        ]);

        return redirect()->route('journal.index');
    }

    public function edit(JournalEntry $journal)
    {
        $this->authorizeOwnership($journal);

        return view('journal.edit', compact('journal'));
    }

    public function update(Request $request, JournalEntry $journal)
    {
        $this->authorizeOwnership($journal);

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $journal->update([
            'title' => $data['title'],
            'body' => $data['body'],
        ]);

        return redirect()->route('journal.index');
    }



    public function destroy(JournalEntry $journal)
    {
        $this->authorizeOwnership($journal);

        $journal->delete();

        return redirect()->route('journal.index');
    }

    private function authorizeOwnership(JournalEntry $entry)
    {
        abort_unless($entry->user_id === auth()->id(), 403);
    }
}
