<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\File;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderDirection = $request->order == "asc" ? "ASC" : "DESC";

        $customers = Customer::when($request->has("search"), function($query) use ($request) {
            $query->where("first_name", "LIKE",  "%$request->search%")
            ->orWhere("last_name", "LIKE", "%$request->search%")
            ->orWhere("email", "LIKE", "%$request->search%")
            ->orWhere("phone", "LIKE", "%$request->search%")
            ->orWhere("bank_account_number", "LIKE", "%$request->search%");
        })->orderBy("id", $orderDirection)->get();

        return view("customer.index", compact("customers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("customer.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        $customer = new Customer();

        if($request->hasFile("image")){
            $image = $request->file("image");
            $fileName = $image->store("", "public");
            $filePath = "/uploads/" . $fileName;
            $customer->image = $filePath;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->bank_account_number = $request->bank_account_number; 
        $customer->about = $request->about;
        $customer->save();

        return redirect()->route("customers.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view("customer.show", compact("customer"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return  view("customer.edit", compact("customer"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerStoreRequest $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        if($request->hasFile("image")){
            File::delete(public_path($customer->image));
            $image = $request->file( "image");
            $fileName = $image->store("", "public");
            $filePath = "/uploads/" . $fileName;
            $customer->image = $filePath;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->bank_account_number = $request->bank_account_number;
        $customer->about = $request->about;
        $customer->save();
        return redirect()->route("customers.index"); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        // File::delete(public_path($customer->image));
        $customer->delete();
        return redirect()->route("customers.index");
    }

    public function trashIndex(Request $request) {
        $orderDirection = $request->order == "asc" ? "ASC" : "DESC";

        $customers = Customer::when($request->has("search"), function($query) use ($request) {
            $query->where("first_name", "LIKE",  "%$request->search%")
            ->orWhere("last_name", "LIKE", "%$request->search%")
            ->orWhere("email", "LIKE", "%$request->search%")
            ->orWhere("phone", "LIKE", "%$request->search%")
            ->orWhere("bank_account_number", "LIKE", "%$request->search%");
        })->orderBy("id", $orderDirection)->onlyTrashed()->get();

        return view("customer.trash", compact("customers"));
    }

    public function restore(int $id) {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->back();
    }

    public function forceDestroy(int $id) {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        File::delete(public_path($customer->image));
        $customer->forceDelete();

        return redirect()->back();  
    }
}
