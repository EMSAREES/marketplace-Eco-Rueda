<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    // Mostrar catálogo
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // BÚSQUEDA
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // FILTRO MATERIAL
        if ($request->filled('material') && $request->material != 'all') {
            $query->where('material', $request->material);
        }

        // FILTRO PRECIO
        if ($request->filled('price') && $request->price != 'all') {
            switch ($request->price) {
                case 'lt50':  $query->where('price', '<', 50); break;
                case '50-100': $query->whereBetween('price', [50, 100]); break;
                case '100-200': $query->whereBetween('price', [100, 200]); break;
                case 'gt200':  $query->where('price', '>', 200); break;
            }
        }

        // PAGINACIÓN
        $products = $query->paginate(12)->appends($request->query());

        return view('products.index', compact('products'));
    }


    // Mostrar detalle
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $images = $product->images; // Todas las imágenes ordenadas
        return view('products.show', compact('product', 'images'));
    }

    // PANEL VENDEDOR - Formulario para crear producto
    public function create()
    {
        // Verificar que sea vendedor
        if (!Auth::check() || Auth::user()->role !== 'vendor') {
            return redirect()->route('login')
                ->with('error', 'Debes ser vendedor para crear productos');
        }

        $product = new Product();
        return view('vendor.products.create', compact('product'));
    }

    // PANEL VENDEDOR - Guardar producto con múltiples imágenes
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'material' => 'required|string',
            'stock' => 'required|integer|min:0',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        try {
            $product = Product::create([
                'vendor_id' => Auth::id(),
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'material' => $request->material,
                'color' => $request->color ?? null,
                'is_active' => $request->is_active ?? 1,
                'stock' => $request->stock,
            ]);

            $basePath = public_path('images/products/');
            if (!File::exists($basePath)) {
                File::makeDirectory($basePath, 0755, true);
            }

            $order = 1;

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $filename = $product->id . '-' . time() . '-' . uniqid() . '.' . $ext;

                    // Mover archivo directamente
                    // $file->move($basePath, $filename);

                    // Opción: redimensionar con GD nativo
                    // $this->resizeImage($basePath . $filename, 600, 600);

                    $path = $file->store('products', 'public');

                    // Guardar referencia
                    $product->images()->create([
                        // 'image_path' => 'images/products/' . $filename,
                        'image_path' => 'storage/' . $path,
                        'order' => $order,
                        'is_primary' => $order === 1,
                    ]);

                    $order++;
                }
            }

            session()->flash('success', 'Producto creado con exito.');

            return response()->json([
                'success' => true,
                'message' => 'Producto creado correctamente',
                'redirect' => route('vendor.products.create'),
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Función para redimensionar imagen con GD
    private function resizeImage($path, $width, $height)
    {
        list($w, $h, $type) = getimagesize($path);

        $ratio = $w / $h;
        if ($width/$height > $ratio) {
            $new_width = $height * $ratio;
            $new_height = $height;
        } else {
            $new_height = $width / $ratio;
            $new_width = $width;
        }

        $src = null;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($path);
                break;
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($path);
                break;
        }

        $dst = imagecreatetruecolor($width, $height);

        // Fondo blanco para PNG/GIF
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        $x = ($width - $new_width) / 2;
        $y = ($height - $new_height) / 2;

        imagecopyresampled($dst, $src, $x, $y, 0, 0, $new_width, $new_height, $w, $h);

        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($dst, $path, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($dst, $path);
                break;
            case IMAGETYPE_GIF:
                imagegif($dst, $path);
                break;
        }

        imagedestroy($src);
        imagedestroy($dst);
    }

    // PANEL VENDEDOR - Editar producto
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('isProductOwner', $product);
        return view('vendor.products.edit', compact('product'));
    }

    // PANEL VENDEDOR - Actualizar producto
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0.01',
        'material' => 'required|string',
        'stock' => 'required|integer|min:0',
        'color' => 'nullable|string|max:50',
        'is_active' => 'nullable|boolean',
    ]);

    try {
        $product = Product::findOrFail($id);

        // temporal: comentar la autorización
        // $this->authorize('isProductOwner', $product);

        $product->update($request->only([
            'name', 'description', 'price', 'material', 'color', 'is_active', 'stock'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'redirect' => route('vendor.dashboard'),
        ]);

    } catch (\Exception $e) {
        Log::error('Error al actualizar producto: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el producto: ' . $e->getMessage(),
        ], 500);
    }
}


    // PANEL VENDEDOR - Eliminar producto
    public function destroy($id)
    {
        $user = Auth::user();

        // Encontrar producto del usuario
        $product = $user->products()->findOrFail($id);

        // Borrar imágenes físicas
        foreach ($product->images as $image) {
            if (Storage::exists($image->path)) {
                Storage::delete($image->path);
            }
        }

        // Borrar registros de imágenes
        $product->images()->delete();

        // Borrar producto
        $product->delete();

        session()->flash('success', 'Empleto eliminado con exito.');

        return response()->json([
            'status' => true,
        ]);
    }
}
