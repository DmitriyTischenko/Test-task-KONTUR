<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(ContactFormRequest $request)
    {
        $contact = Contact::create($request->validated());

        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new ContactMail($contact));

        return response()->json(['message' => 'Форма успешно отправлена!'], 200);
    }
}
