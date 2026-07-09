<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 一覧表示
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('products.index', compact('products'));
    }

    // 詳細表示
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 作成フォーム表示
    public function create()
    {
        return view('products.create');
    }

    // 作成処理
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'price'       => 'required|integer|min:0',
            'description' => 'required',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|max:100',
        ]);

        Product::create($request->only('name', 'price', 'description', 'stock', 'category'));

        return redirect()->route('products.index')->with('success', '商品を作成しました！');
    }

    // 編集フォーム表示
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // 編集処理
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'price'       => 'required|integer|min:0',
            'description' => 'required',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|max:100',
        ]);

        $product->update($request->only('name', 'price', 'description', 'stock', 'category'));

        return redirect()->route('products.index')->with('success', '商品を更新しました！');
    }

    // 削除処理
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました！');
    }
}