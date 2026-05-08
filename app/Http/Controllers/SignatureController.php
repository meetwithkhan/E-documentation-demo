<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:max_width=800,max_height=400',
        ]);

        $user = auth()->user();

        // Delete old signature
        if ($user->signature_path) {
            Storage::disk('public')->delete($user->signature_path);
        }

        // Store new signature
        $path = $request->file('signature')->store(
            'signatures/' . $user->id,
            'public'
        );

        $user->update(['signature_path' => $path]);

        return back()->with('success', 'Signature uploaded successfully.');
    }

    public function destroy()
    {
        $user = auth()->user();

        if ($user->signature_path) {
            Storage::disk('public')->delete($user->signature_path);
            $user->update(['signature_path' => null]);
        }

        return back()->with('success', 'Signature removed.');
    }
}