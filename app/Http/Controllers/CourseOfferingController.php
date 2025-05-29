<?php

namespace App\Http\Controllers;

use App\Models\CourseOffering;
use Illuminate\Http\Request;

class CourseOfferingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fac_filter = $request->query('faculty');
        $data = CourseOffering::with('courseBlueprint', 'offeringProfessors')
            ->get()
            ->filter(function(CourseOffering $el) use ($fac_filter) {
                return is_null($fac_filter) ? 
                        true : $el->courseBlueprint->faculty_code === $fac_filter;
            })->toArray();
        return array_values($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseOffering $courseOffering)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseOffering $courseOffering)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseOffering $courseOffering)
    {
        //
    }
}
