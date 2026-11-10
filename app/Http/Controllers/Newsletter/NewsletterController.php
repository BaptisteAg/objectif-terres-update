<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->get('email');

        if (Newsletter::where('email', $email)->first()) {
            return back()->withErrors('Vous êtes déjà abonné à la newsletter');
        }

        Newsletter::create(compact('email'));

        return back()->with('success', 'Vous êtes désormais abonné à la newsletter.');
    }
}
