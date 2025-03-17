<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        // Get all images from the storage folder
        $promotionImages = collect(Storage::files('public/promotions'))
                            ->map(fn($image) => Storage::url($image));

        return view('admin.promotions.index', compact('promotionImages'));
    }

    public function store(Request $request)
    {
        \Log::info('Upload Request Data:', $request->all());

        // Check if the file was uploaded
        if (!$request->hasFile('image')) {
            \Log::error('No file was received.');
            return back()->with('error', 'No file selected.');
        }

        $file = $request->file('image');

        // Log file details
        \Log::info('File received:', [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'path' => $file->getRealPath()
        ]);

        // Validate file
        if (!$file->isValid()) {
            \Log::error('Invalid file upload.');
            return back()->with('error', 'Invalid file.');
        }

        // Store the file
        $path = $file->store('public/promotions');

        // Check if storage succeeded
        if ($path) {
            \Log::info('File stored successfully at: ' . $path);
            return back()->with('success', 'Promotion uploaded successfully.');
        } else {
            \Log::error('File storage failed.');
            return back()->with('error', 'File storage failed.');
        }
    }



    public function destroy(Request $request)
    {
        $imagePath = str_replace('/storage/', 'public/', $request->image);

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
            return back()->with('success', 'Promotion deleted.');
        }

        return back()->with('error', 'Image not found.');
    }
}
