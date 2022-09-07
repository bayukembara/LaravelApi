<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidatesResource;
use App\Models\Candidates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = Candidates::latest()->paginate(5);

        //return collection of posts as a resource
        return new CandidatesResource(true, 'List Data Candidates', $candidates);
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
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:candidates|email',
            'phone' => 'required|unique:candidates|min:10|numeric',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $candidates = Candidates::create([
            'job_id' => $request->job_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'year' => $request->year,
        ]);

        return new CandidatesResource(true, 'Data Candidates Has Been Added', $candidates);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidates = Candidates::find($id);
        return new CandidatesResource(true, 'Data Candidates Found!', $candidates);
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
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:candidates|email',
            'phone' => 'required|unique:candidates|min:10|numeric',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $candidates = Candidates::find($id);
        $candidates->job_id = $request->job_id;
        $candidates->name = $request->name;
        $candidates->email = $request->email;
        $candidates->phone = $request->phone;
        $candidates->year = $request->year;
        $candidates->save();

        return new CandidatesResource(true, 'Data Candidates Has Been Edited!', $candidates);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidates = Candidates::find($id);
        $candidates->delete();
        return new CandidatesResource(true, 'Data Candidates Has Been Deleted!', $candidates);
    }
}