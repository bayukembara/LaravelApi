<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobsResource;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Jobs::latest()->paginate(5);

        //return collection of posts as a resource
        return new JobsResource(true, 'List Data Jobs', $jobs);
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
            'name' => 'required|unique:jobs|min:2',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create jobs
        $jobs = Jobs::create([
            'name' => $request->name,
        ]);

        //return response
        return new JobsResource(true, 'Data Jobs Berhasil Ditambahkan!', $jobs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show(Jobs $jobs, $id)
    {
        $jobs = Jobs::findorfail($id);
        return new JobsResource(true, 'Data Jobs Ditemukan!', $jobs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobs $jobs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobs $jobs, $id)
    {
        $data = Jobs::findorfail($id);
        // dd($request);
        $data->name = $request->name;
        $data->save();
        //return response
        return new JobsResource(true, 'Data Jobs Berhasil Diubah!', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobs $jobs, $id)
    {
        $jobs = Jobs::where('id', $id)->firstorfail();
        $jobs->delete();
        return new JobsResource(true, 'Data Jobs Berhasil Dihapus!', $jobs);
    }
}