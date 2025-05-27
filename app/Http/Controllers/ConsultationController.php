<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\SupportEducatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Affiche les statistiques des consultations par type de support
     *
     * @return \Illuminate\Http\Response
     */
     public function statistiquesParType()
    {
        // Récupérer l'id du professeur connecté
        $professeurId = auth()->id();

        // Récupérer les id_support des supports créés par ce professeur
        $supportsDuProf = SupportEducatif::where('id_user', $professeurId)->pluck('id_support');

        // Récupérer les supports avec le nombre de consultations groupées par type
       $statistiques = SupportEducatif::with(['type', 'matiere', 'consultations.user'])
        ->withCount('consultations') 
        ->whereIn('id_support', $supportsDuProf)
        ->get()
        ->groupBy(function ($support) {
            return $support->type->nom ?? 'Autre';
        });

        // Retourner la vue avec les statistiques
        return view('consultations', compact('statistiques'));
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
        // Validation simple
        $request->validate([
            'id_support' => 'required|exists:support_educatifs,id_support',
        ]);

        // Récupérer l'id de l'étudiant connecté (authentifié)
        $id_user = Auth::id();

        // Créer la consultation
        $consultation = Consultation::create([
            'id_user' => $id_user,
            'id_support' => $request->id_support,
            'date_consultation' => now(),
        ]);

        return response()->json([
            'message' => 'Consultation enregistrée avec succès.',
            'consultation' => $consultation
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consultation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultation $consultation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        //
    }
}

