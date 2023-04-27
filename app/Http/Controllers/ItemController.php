<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemFormRequest;
use App\Models\Item;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    use DatatableTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('item.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['html' =>  view('item.create')->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemFormRequest $request)
    {
       
        $item = new Item();
        $item->name = $request->name;
        $item->user_id = Auth::id();
        $item->description = $request->description;
        $item->save();

        return redirect(route('item.index'))->with('success_s', 'Item Successfully Created');
    }

    public function dataList(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'description',
            2 => 'action',
        );

        $totalData = Item::where('user_id',Auth::id())->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $customcollections = Item::where('user_id', Auth::id())->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            $row['name'] = $item->name;
            $row['description'] =  $item->description;
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('item.edit', $item->id),
                    'icon' => 'fas fa-edit text-dark-pastel-green',
                    'target' => '#editItem',
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'action' => route('item.destroy', $item->id),
                    'icon' => 'fas fa-times text-orange-red',
                    'class' => 'delete-confrim',
                ]),
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
        $item = Item::findorfail($id);
        $html =  view('item.edit', compact('item'))->render();
        return response()->json(['html' => $html], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemFormRequest $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->user_id = Auth::id();
        $item->description = $request->description;
        $item->save();

        return redirect(route('item.index'))->with('success_s', 'Item Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Item::findOrFail($id);

        if ($delete->product()->exists()) {
            return response()->json([
                'success_s' => false,
                'message' => 'Item could not be deleted because it is already used',
            ], 500);
        }

        $delete->delete();

        return response()->json([
            'success_s' => true,
            'message' => 'Item Deleted Successfully',
        ], 200);
    }

}
