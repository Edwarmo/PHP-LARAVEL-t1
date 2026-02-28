<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para crear perfil
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Procesa la creación de perfil con imagen
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        // Procesar la imagen
        $image = $request->file('photo');
        
        // Crear nombre único para la imagen
        $filename = time() . '_' . $image->getClientOriginalName();
        
        // Procesar imagen con intervention/image
        $processedImage = Image::read($image);
        
        // Redimensionar a 300x300 (avatar estándar)
        $processedImage->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // Guardar imagen procesada
        $path = public_path('uploads/profiles/' . $filename);
        
        // Crear directorio si no existe
        if (!file_exists(public_path('uploads/profiles'))) {
            mkdir(public_path('uploads/profiles'), 0755, true);
        }
        
        // Guardar la imagen procesada
        $processedImage->save($path, 85, 'jpg');

        // Datos del perfil
        $profile = [
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $filename,
            'photo_url' => asset('uploads/profiles/' . $filename),
            'original_size' => $image->getSize(),
            'processed_size' => filesize($path),
            'dimensions' => $processedImage->width() . 'x' . $processedImage->height(),
        ];

        return view('profile.show', compact('profile'));
    }
}
