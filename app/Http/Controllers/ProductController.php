<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Item;
use App\Models\Product;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use DatatableTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = $this->getItemList();
        return response()->json(['html' =>  view('product.create', compact('item'))->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {

        $image = $request->file('image');
        
        $product = new Product();
        $product->user_id = Auth::id();
        $product->item_id = $request->item_id;
        $product->price = $request->price;
        $product->qty = $request->qty;

        if($request->file('image')){
            $file = $request->file('image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $path = $file->storeAs('product', $fileName);

            $product->image = $path;
        }
        $product->save();

        return redirect(route('product.index'))->with('success_s', 'Product Successfully Created');
    }

    public function dataList(Request $request)
    {
        $user = Auth::user();

        $columns = array(
            0 => 'image',
            1 => 'item_id',
            2 => 'price',
            3 => 'qty',
            4 => 'action',
        );

        $totalData = Product::where('user_id', Auth::id())->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $customcollections = Product::where('user_id', Auth::id())->with('item')
            ->orWhereHas('item', function ($item_query) use ($search) {
                return $item_query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($search) . '%');
            });

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            $row['image'] = $this->image($item->image);
            $row['item_id'] = $item->item->name;
            $row['price'] =  $item->price;
            $row['qty'] =  $item->qty;
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('product.edit', $item->id),
                    'icon' => 'fas fa-edit text-dark-pastel-green',
                    'target' => '#editProduct',
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'action' => route('product.destroy', $item->id),
                    'icon' => 'fas fa-times text-orange-red',
                    'class' => 'delete-confrim',
                ])
            ]);

            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
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
        $product = Product::findorfail($id);
        $item = $this->getItemList();

        $html =  view('product.edit', compact('product', 'item'))->render();
        return response()->json(['html' => $html], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->user_id = Auth::id();
        $product->item_id = $request->item_id;
        $product->price = $request->price;
        $product->qty = $request->qty;
        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $path = $file->storeAs('product', $fileName);

            $product->image = $path;
        }
        $product->save();

        return redirect(route('product.index'))->with('success_s', 'Product Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Product::findOrFail($id);
        $delete->delete();

        return response()->json([
            'success_s' => true,
            'message' => 'Product Deleted Successfully',
        ], 200);
    }

    public function getItemList()
    {
        $company = Item::where('user_id', Auth::id())-> get();

        return $company;
    }
}
