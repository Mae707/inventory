<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $warehouses = Warehouse::orderBy('name', 'ASC')->pluck('name', 'id');

        $products = Product::all();
       return view('products.index', compact('category', 'warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
            'image'         => 'required',
            'category_id'   => 'required',
            'expiry_date'   => 'nullable|date',
            'status'        => 'required|in:active,inactive',  
            'warehouse_id' => 'nullable|exists:warehouses,id'        
        ]);

        $input = $request->all();
        $input['image'] = null;

        if ($request->hasFile('image')){
            $input['image'] = '/upload/products/'.str_slug($input['nama'], '-').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/products/'), $input['image']);
        }

        Product::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Products Created'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');
        $product = Product::with (['category', 'warehouse'])->find($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
//            'image'         => 'required',
            'category_id'   => 'required',
            'expiry_date'   => 'nullable|date',
            'status'        => 'required|in:active,inactive',
            'warehouse_id' => 'nullable|exists:warehouses,id'

        ]);

        $input = $request->all();
        $produk = Product::findOrFail($id);

        $input['image'] = $produk->image;

        if ($request->hasFile('image')){
            if (!$produk->image == NULL){
                unlink(public_path($produk->image));
            }
            $input['image'] = '/upload/products/'.str_slug($input['nama'], '-').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/products/'), $input['image']);
        }

        $produk->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Products Update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->image == NULL){
            unlink(public_path($product->image));
        }

        Product::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Products Deleted'
        ]);
    }


    public function apiProducts()
{
    $products = Product::with(['category', 'warehouse'])->select('products.*')->get(); // <-- add ->get()

    return Datatables::of($products) // <-- use $products, not $product
        ->addColumn('category_name', function ($product){
            return $product->category ? $product->category->name : '-';
        })
        ->addColumn('warehouse_name', function ($product) {
            return $product->warehouse ? $product->warehouse->name : '-';
        })
        ->addColumn('show_photo', function($product){
            if ($product->image == NULL){
                return 'No Image';
            }
            return '<img class="rounded-square" width="50" height="50" src="'. url($product->image) .'" alt="">';
        })
        ->addColumn('status', function($product) {
            $class = $product->status == 'active' ? 'label label-success' : 'label label-danger';
            return '<span class="'.$class.'">'.ucfirst($product->status).'</span>';
        })
        ->addColumn('action', function($product){
            return'<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
        })
        ->addColumn('expiry_date', function($product){
            return $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('Y-m-d') : '-';
        })
        ->rawColumns(['status','category_name','warehouse_name','show_photo','action'])
        ->make(true);
}


  public function status()
    {
        $products = Product::where('status', '!=', 'active')->get();
        return view('status.index', compact('products'));
    }




    public function lowStock()
    {
        $lowStockProducts = Product::where('qty', '<=', 10)->get();
        return response()->json($lowStockProducts);
    }

    public function search(Request $request)
        {
            $search = $request->get('search');
            $products = Product::where('nama', 'LIKE', "%{$search}%")
                ->orWhere('harga', 'LIKE', "%{$search}%")
                ->orWhere('qty', 'LIKE', "%{$search}%")
                ->get();

            return response()->json($products);
    }
}
