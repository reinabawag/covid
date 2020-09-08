<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use Illuminate\Support\Collection;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return view('visitor.index')->with(['questions' => $questions]);
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
        $visitor = new Visitor;
        $visitor->name = $request->name;
        $visitor->temp = $request->temp;
        $visitor->gender = $request->gender;
        $visitor->age = $request->age;
        $visitor->address = $request->address;
        $visitor->purpose = $request->purpose;
        $visitor->company_name = $request->company_name;
        $visitor->company_address = $request->company_address;
        $visitor->save();

        $answers = $this->makeCollection($request->ans);
        $additional = $this->makeCollection($request->additional);

        foreach ($answers as $key => $answer) {
            $answer = new Answer(['answer' => isset($additional[$key]) ? $additional[$key] : $answer]);
            $answer->question()->associate($key);
            $visitor->answers()->save($answer);
        }

        return response()->json(['answers' => $answers, 'additional' => $additional]);
    }

    public function makeCollection($data)
    {
        return collect($data)->map(function($item, $key) {
            return $item;
        })->reject(function ($item) {
            return empty($item);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}
