<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
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
    // public function create()
    // {
    //     $this->authorize('isVendor'); // Solo vendedores
    //     return view('vendor.products.create');
    // }

    // // PANEL VENDEDOR - Guardar producto con múltiples imágenes
    // public function store(Request $request)
    // {
    //     $this->authorize('isVendor');

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'price' => 'required|numeric|min:0.01',
    //         'stock' => 'required|integer|min:0',
    //         'material' => 'required|string',
    //         'color' => 'nullable|string',
    //         'images' => 'required|array|min:1|max:10', // Mínimo 1, máximo 10 imágenes
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 2MB por imagen
    //     ]);

    //     // Crear producto
    //     $product = Product::create([
    //         'vendor_id' => auth()->id(),
    //         'name' => $validated['name'],
    //         'description' => $validated['description'],
    //         'price' => $validated['price'],
    //         'stock' => $validated['stock'],
    //         'material' => $validated['material'],
    //         'color' => $validated['color'],
    //         'is_active' => true
    //     ]);

    //     // Guardar imágenes
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $index => $image) {
    //             // Guardar en storage/app/public/products/
    //             $path = $image->store('products', 'public');

    //             // Crear registro en ProductImage
    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'image_path' => $path,
    //                 'order' => $index + 1,
    //                 'is_primary' => $index === 0 // Primera es principal
    //             ]);
    //         }
    //     }

    //     return redirect()->route('vendor.products.index')
    //         ->with('success', 'Producto creado exitosamente con ' . count($validated['images']) . ' imágenes');
    // }

    // // PANEL VENDEDOR - Editar producto
    // public function edit($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $this->authorize('isProductOwner', $product);
    //     return view('vendor.products.edit', compact('product'));
    // }

    // // PANEL VENDEDOR - Actualizar producto
    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);
    //     $this->authorize('isProductOwner', $product);

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'price' => 'required|numeric|min:0.01',
    //         'stock' => 'required|integer|min:0',
    //         'material' => 'required|string',
    //         'color' => 'nullable|string',
    //         'images' => 'nullable|array|max:10',
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'remove_images' => 'nullable|array' // IDs de imágenes a eliminar
    //     ]);

    //     // Actualizar datos básicos
    //     $product->update([
    //         'name' => $validated['name'],
    //         'description' => $validated['description'],
    //         'price' => $validated['price'],
    //         'stock' => $validated['stock'],
    //         'material' => $validated['material'],
    //         'color' => $validated['color']
    //     ]);

    //     // Eliminar imágenes si se solicita
    //     if ($request->has('remove_images')) {
    //         foreach ($validated['remove_images'] as $imageId) {
    //             $image = ProductImage::findOrFail($imageId);
    //             // Eliminar archivo del storage
    //             Storage::disk('public')->delete($image->image_path);
    //             $image->delete();
    //         }
    //     }

    //     // Agregar nuevas imágenes si se cargan
    //     if ($request->hasFile('images')) {
    //         $currentOrder = $product->images()->max('order') ?? 0;

    //         foreach ($request->file('images') as $image) {
    //             $path = $image->store('products', 'public');
    //             $currentOrder++;

    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'image_path' => $path,
    //                 'order' => $currentOrder
    //             ]);
    //         }
    //     }

    //     return redirect()->route('vendor.products.index')
    //         ->with('success', 'Producto actualizado exitosamente');
    // }

    // // PANEL VENDEDOR - Eliminar producto
    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $this->authorize('isProductOwner', $product);

    //     // Eliminar imágenes
    //     foreach ($product->images as $image) {
    //         Storage::disk('public')->delete($image->image_path);
    //         $image->delete();
    //     }

    //     $product->delete();

    //     return redirect()->route('vendor.products.index')
    //         ->with('success', 'Producto eliminado exitosamente');
    // }
}
