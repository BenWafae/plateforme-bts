<?php
namespace App\Http\Controllers;

use App\Models\Question; // Utilisation du modèle Question
use App\Models\Reponse;  // Utilisation du modèle Reponse
use Illuminate\Http\Request;

class ForumController extends Controller
{
    
    
    
   
    
        // Afficher toutes les questions pour les professeurs
        public function index()
        {
            $questions = Question::with('reponses')->get();
            return view('forum_prof', compact('questions'));
        }
    
        // Permettre au professeur de répondre à une question
        public function repondre(Request $request, $id)
        {
            $request->validate([
                'reponse' => 'required|string',
            ]);
    
            $question = Question::findOrFail($id);
    
            // Création de la réponse
            Reponse::create([
                'id_question' => $question->id_question,  // Utilise 'id_question'
                'contenu' => $request->input('reponse'),
                'id_user' => auth()->user()->id_user,
            ]);
    
            return redirect()->route('professeur.questions.index')->with('success', 'Réponse envoyée avec succès.');
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
        //
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
}


