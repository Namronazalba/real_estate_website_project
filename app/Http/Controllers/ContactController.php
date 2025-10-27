<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\House;

class ContactController extends Controller
{
    public function store(Request $request, $houseId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'mobile' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        $house = House::findOrFail($houseId);

        ContactMessage::create([
            'house_id' => $house->id,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thank you for your inquiry! We will contact you soon.');
    }

    public function index(Request $request)
    {
        $query = ContactMessage::with('house')->latest();

        $messages = $query->paginate(15)->appends($request->query());

        return view('contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('contacts.show', compact('contact'));
    }
    
    public function markRead(ContactMessage $contact)
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }


}
