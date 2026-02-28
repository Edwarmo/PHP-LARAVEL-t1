@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-user-circle text-red-600 mr-2"></i>
            Crear Perfil de Usuario
        </h1>
        <p class="text-gray-600 mt-1">Sube una imagen que será procesada con Intervention Image</p>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-400 transition">
                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <label for="photo" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600">Haz clic para subir una imagen</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF (máx 5MB)</p>
                    </label>
                </div>
                <div id="preview-container" class="mt-4 hidden">
                    <p class="text-sm text-gray-600 mb-2">Vista previa:</p>
                    <img id="preview" class="max-w-xs rounded-lg shadow" src="" alt="Preview">
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-save mr-2"></i>Crear Perfil
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="bg-gray-50 rounded-xl shadow-lg p-6 mt-6">
        <h3 class="font-bold text-gray-800 mb-3">
            <i class="fas fa-info-circle text-red-600 mr-2"></i>Procesamiento de imagen:
        </h3>
        <p class="text-sm text-gray-600">
            La imagen será procesada usando <strong>Intervention Image</strong> y redimensionada a 
            <strong>300x300 píxeles</strong> para crear un avatar estándar. La imagen se guardará 
            en formato JPG con calidad del 85%.
        </p>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('preview');
        output.src = reader.result;
        document.getElementById('preview-container').classList.remove('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
