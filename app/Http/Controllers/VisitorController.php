<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use Illuminate\Support\Collection;
use App\Events\NewVisitor;
use App\Http\Resources\VisitorCollection;
use App\Http\Resources\Visitor as VisitorResource;
use App\Events\ForApproval;

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
    public function getVisitors()
    {
        return new VisitorCollection(Visitor::all());
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

        event(new NewVisitor($visitor));

        return response()->json(['message' => 'Kindly wait for confirmation.', 'visitor' => $visitor]);
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
        return new VisitorResource($visitor->loadMissing(['answers.question']));
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

    public function approval(Visitor $visitor, Request $request)
    {
        if (event(new ForApproval($visitor, $request->approve)))
            return response()->json(true);
    }
}
