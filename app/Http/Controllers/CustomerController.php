<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Database\QueryException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $customer = Customer::create([
                'id_customer' => $request->input('id_customer'),
                'nama_customer' => $request->input('nama_customer'),
                'telp_customer' => $request->input('telp_customer'),
                'alamat_customer' => $request->input('alamat_customer'),
            ]);
        } catch (QueryException $exception) {
            $errorCreate = $exception->errorInfo;
        }
        
        if (isset($errorCreate)) {
            return response()->json([
                'errors' => $errorCreate,
                'request' => $request->input(),
            ], 500);
        }

        return response()->json([
            'message' => 'data saved successfully',
            'data' => $customer,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
