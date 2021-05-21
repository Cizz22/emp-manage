<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp = Employee::with(['departement','payment'])->get();

        $response = [
            'message' => 'List Data Departement',
            'data' => $emp
        ];

        return response()->json($response, Response::HTTP_OK);

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
        $request->validate([
            'name' => 'required',
            'contact' => 'required|numeric',
            'email' => 'required|email',
            'departement_id' => 'required'
        ]);

        try {
            Employee::create($request->all());
            $response = [
                'message' => 'Data Berhasil Disimpan',
                'data' => $request->all()
            ];
           return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error '.$e
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emp = Employee::with(['departement' , 'payment'])->findOrFail($id);
        $response =[
            'message' => 'Data Employee',
            'data' => $emp
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $employee = Employee::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'contact' => 'required|numeric',
            'email' => 'required|unique:employees,email',
        ]);

        try {
            $employee->update($request->all());
            $response = [
                'message' => 'Data Berhasil Dimodifikasi',
                'data' => $request->all()
            ];
           return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error '.$e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        $response = [
            'message' => 'Data Berhasil Dihapus'
        ];
        return response()->json($response, Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'detail' => 'required',
            'date' => 'required'
        ]);

        try {
            Payment::create($request->all());

            $response = [
                'message' => 'Data Berhasil Disimpan',
                'data' => $request->all()
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error '.$e
            ]);
        }
    }

    public function destroyPayment($id)
    {
        Payment::destroy($id);
        $response = [
            'message' => 'Data Berhasil Dihapus'
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
