<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SkillsResource;
use App\Models\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skill = skills::latest()->paginate(5);

        //return collection of posts as a resource
        return new SkillsResource(true, 'List Data skill', $skill);
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
            'name' => 'required|unique:skills|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $skill = Skills::create([
            'name' => $request->name,
        ]);
        return new SkillsResource(true, 'Data Skills Berhasil Ditambahkan', $skill);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function show(Skills $skills, $id)
    {
        $skill = Skills::findorfail($id);
        return new SkillsResource(true, 'Data skill Ditemukan!', $skill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function edit(Skills $skills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skills $skills, $id)
    {
        $skill = Skills::findorfail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:skills|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // dd($request);
        $skill->name = $request->name;
        $skill->save();
        //return response
        return new SkillsResource(true, 'Data Skills Berhasil Diubah!', $skill);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skills $skills, $id)
    {
        $skill = Skills::where('id', $id)->firstorfail();
        $skill->delete();
        return new SkillsResource(true, 'Data Skill Berhasil Dihapus!', $skill);
    }
}