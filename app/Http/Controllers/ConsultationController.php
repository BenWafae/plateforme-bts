<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\Consultation;
use App\Models\Matiere;
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
public function statistiquesParType(Request $request)
{
    $professeurId = auth()->id();
    $supportsDuProf = SupportEducatif::where('id_user', $professeurId)->pluck('id_support');

    $selectedType = $request->input('type');      // ID du type sélectionné
    $selectedMatiere = $request->input('matiere'); // ID de la matière sélectionnée

    $statistiques = SupportEducatif::with(['type', 'matiere', 'consultations.user'])
        ->withCount('consultations')
        ->whereIn('id_support', $supportsDuProf)
        ->get()
        ->groupBy(function ($support) {
            return $support->type->nom ?? 'Autre';
        });

    $consultationsQuery = Consultation::whereIn('id_support', $supportsDuProf)
        ->with(['user', 'support.matiere', 'support.type'])
        ->orderByDesc('date_consultation');

    if ($selectedType) {
        $consultationsQuery->whereHas('support.type', function ($query) use ($selectedType) {
            $query->where('id_type', $selectedType);
        });
    }

    if ($selectedMatiere) {
        $consultationsQuery->whereHas('support.matiere', function ($query) use ($selectedMatiere) {
            $query->where('id_Matiere', $selectedMatiere);
        });
    }

    $consultations = $consultationsQuery->paginate(5)->withQueryString();

    $consultationsParSemaine = [];
    foreach ($statistiques as $type => $supports) {
        foreach ($supports as $support) {
            foreach ($support->consultations as $consultation) {
                $semaine = Carbon::parse($consultation->date_consultation)->startOfWeek()->format('Y-m-d');
                $consultationsParSemaine[$type][$semaine][] = $consultation;
            }
        }
    }

    $types = \App\Models\Type::all();
    $matieres = \App\Models\Matiere::where('id_user', $professeurId)->get(); // matières du prof

    return view('consultations', compact(
        'statistiques',
        'consultationsParSemaine',
        'consultations',
        'types',
        'selectedType',
        'matieres',
        'selectedMatiere'
    ));
}


public function statistiquesGlobalesPourAdmin(Request $request)
{
    $matieres = Matiere::all();
    $types = \App\Models\Type::all();

    $supports = SupportEducatif::with(['matiere.filiere', 'consultations.user'])->get();

    // Total des consultations par matière (global)
    $consultationsParMatiere = $supports->groupBy(function ($support) {
        return $support->matiere->Nom ?? 'Autre';
    })->map(function ($group) {
        return $group->sum(function ($support) {
            return $support->consultations->count();
        });
    });

    // ➕ Consultations par matière par semaine
    $consultationsParMatiereParSemaine = [];

    foreach ($supports as $support) {
        $matiereNom = $support->matiere->Nom ?? 'Autre';

        foreach ($support->consultations as $consultation) {
            $semaine = Carbon::parse($consultation->date_consultation)->startOfWeek()->format('Y-m-d');

            if (!isset($consultationsParMatiereParSemaine[$matiereNom])) {
                $consultationsParMatiereParSemaine[$matiereNom] = [];
            }

            if (!isset($consultationsParMatiereParSemaine[$matiereNom][$semaine])) {
                $consultationsParMatiereParSemaine[$matiereNom][$semaine] = 0;
            }

            $consultationsParMatiereParSemaine[$matiereNom][$semaine]++;
        }
    }

    // 🔽 Facultatif : trier les semaines pour chaque matière
    foreach ($consultationsParMatiereParSemaine as &$semaineData) {
        ksort($semaineData);
    }

    // Récupération des consultations filtrées (comme avant)
    $consultationsQuery = \App\Models\Consultation::with(['user', 'support.matiere.filiere', 'support.type']);

    if ($request->filled('matiere')) {
        $consultationsQuery->whereHas('support', function ($query) use ($request) {
            $query->where('id_Matiere', $request->matiere);
        });
    }

    if ($request->filled('type')) {
        $consultationsQuery->whereHas('support', function ($query) use ($request) {
            $query->where('id_type', $request->type);
        });
    }

    $consultations = $consultationsQuery
        ->orderByDesc('date_consultation')
        ->paginate(5)
        ->withQueryString();

        // 📊 Données pour les recommandations (optionnel - déjà calculées avec $consultationsParMatiere)
$totalConsultations = $consultationsParMatiere->sum();
$moyenneConsultations = $consultationsParMatiere->avg();

// Les recommandations sont calculées directement dans le Blade avec les données existantes
// Pas besoin de calculs supplémentaires côté contrôleur

    return view('admin_consultation', compact(
        'consultationsParMatiere',
        'consultationsParMatiereParSemaine',
        'consultations',
        'matieres',
        'types',
        'totalConsultations',      
       'moyenneConsultations' 
    ));
}

/**
 * Générer des recommandations automatiques basées sur les données
 */


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