<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Exception;

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
        } catch (Exception $exception) {
            $errorCreate = $exception;
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
        $errorValidate = $this->validateIDRequest($id);
        if ($errorValidate != '') {
            return response()->json([
                'errors' => $errorValidate,
            ], 422);
        }
        
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json([
                'errors' => 'data not found',
            ], 404);
        }

        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $errorValidate = $this->validateIDRequest($id);
        if ($errorValidate != '') {
            return response()->json([
                'errors' => $errorValidate,
            ], 422);
        }

        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json([
                'errors' => 'data not found',
            ], 404);
        }

        if ($request->has('nama_customer')) {
            $customer->nama_customer = $request->input('nama_customer');
        }
        if ($request->has('telp_customer')) {
            $customer->telp_customer = $request->input('telp_customer');
        }
        if ($request->has('alamat_customer')) {
            $customer->alamat_customer = $request->input('alamat_customer');
        }
        $isSuccessSave = $customer->save();

        if (!$isSuccessSave) {
            return response()->json([
                'errors' => 'error when update',
                'request' => $request->input(),
            ], 500);
        }

        return response()->json([
            'message' => 'data updated successfully',
            'data' => $customer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $errorValidate = $this->validateIDRequest($id);
        if ($errorValidate != '') {
            return response()->json([
                'errors' => $errorValidate,
            ], 422);
        }

        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json([
                'errors' => 'data not found',
            ], 404);
        }

        $customer->delete();
        return response()->json([
            'message' => 'data deleted successfully',
            'data' => $customer,
        ]);
    }

    /**
     * Validate ID Input in URL Path.
     */
    protected function validateIDRequest(string $id) {
        define('ID_CUSTOMER_DB_LENGTH', 5);
        if (strlen($id) != ID_CUSTOMER_DB_LENGTH) {
            return 'The id customer field must be 5 characters.';
        }
        return '';
    }
}
