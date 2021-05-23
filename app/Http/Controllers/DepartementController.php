<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departement = Departement::with(['employee'])->get();

        $response = [
            'message' => 'List Data Departement',
            'data' => $departement
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
            'name' => 'required|unique:departements,name',
        ]);

        try {
            Departement::create($request->all());
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
        $departement = Departement::with(['employee'])->findOrFail($id);

        $response =[
            'message' => 'Data Departement',
            'data' => $departement
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
        $departement = Departement::findOrFail($id);
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $departement->update($request->all());
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
        Departement::find($id)->employee->departement_id = null ;
        Departement::destroy($id);
        $response = [
            'message' => 'Data Berhasil Dihapus'
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
