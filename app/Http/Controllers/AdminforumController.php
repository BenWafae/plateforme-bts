<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Events\QuestionSupprimee;
use Illuminate\Http\Request;

class AdminforumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with(['user', 'reponses.user', 'matiere'])->get();
        return view('forum_admin', compact('questions'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::with(['user', 'reponses.user', 'matiere'])->findOrFail($id);
        return view('detail_forum', compact('question'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Récupérer la question avec ses réponses associées
        $question = Question::with('reponses')->findOrFail($id);  
    
        // Supprimer les réponses associées
        $question->reponses()->delete(); 
    
        // Supprimer la question
        $question->delete();
    
        // Retourner à la liste des questions avec un message de succès
        event(new QuestionSupprimee($question));
        return redirect()->route('admin.questions.index')->with('success', 'Question et ses réponses supprimées avec succès!');
    }
    
}
