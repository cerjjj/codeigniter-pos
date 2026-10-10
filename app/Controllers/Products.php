<?php

namespace App\Controllers;

use App\Controllers\Concerns\HandlesImages;
use App\Models\ProductModel;

class Products extends BaseController
{
    use HandlesImages;

    private ProductModel $products;

    public function __construct()
    {
        $this->products = new ProductModel();
    }

    public function index(): string
    {
        return view('products/index', [
            'title' => 'Products',
            'products' => $this->products->orderBy('is_active', 'DESC')->orderBy('name')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('products/form', ['title' => 'Add product', 'product' => null]);
    }

    public function create()
    {
        return $this->persist();
    }

    public function edit(int $id)
    {
        $product = $this->products->find($id);
        if (! $product) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }

        return view('products/form', ['title' => 'Edit product', 'product' => $product]);
    }

    public function update(int $id)
    {
        if (! $this->products->find($id)) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }

        return $this->persist($id);
    }

    public function archive(int $id)
    {
        $product = $this->products->find($id);
        if (! $product) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }

        $active = (int) ! (bool) $product['is_active'];
        $this->products->update($id, ['is_active' => $active]);

        return redirect()->to('/products')->with('success', $active ? 'Product restored.' : 'Product archived.');
    }

    private function persist(?int $id = null)
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,3072]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'price' => (float) $this->request->getPost('price'),
            'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
            'is_active' => $this->request->getPost('is_active') === null ? 1 : (int) (bool) $this->request->getPost('is_active'),
        ];

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $data['image'] = $this->storeImage($image, 'products', 900, 700);
        }

        $id ? $this->products->update($id, $data) : $this->products->insert($data);

        return redirect()->to('/products')->with('success', $id ? 'Product updated.' : 'Product added.');
    }
}
