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
    // Récupération de toutes les matières pour le menu déroulant
    $matieres =Matiere::all();

    // Statistiques pour le graphe (inchangé)
    $supports = SupportEducatif::with(['matiere.filiere', 'consultations.user'])->get();

    $consultationsParMatiere = $supports->groupBy(function ($support) {
        return $support->matiere->Nom ?? 'Autre';
    })->map(function ($group) {
        return $group->sum(function ($support) {
            return $support->consultations->count();
        });
    });

    // Filtrage des consultations par matière
    $consultations = \App\Models\Consultation::with(['user', 'support.matiere.filiere', 'support.type'])
        ->whereHas('support.matiere', function ($query) use ($request) {
            if ($request->filled('matiere')) {
                $query->where('id_Matiere', $request->matiere);
            }
        })
        ->orderByDesc('date_consultation')
        ->paginate(10);

    return view('admin_consultation', compact(
        'consultationsParMatiere',
        'consultations',
        'matieres'
    ));
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