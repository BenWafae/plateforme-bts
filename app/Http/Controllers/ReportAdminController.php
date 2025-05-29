<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Question;
use App\Models\Support;
use App\Models\Matiere;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReportAdminController extends Controller
{
    // Afficher la liste des signalements
    public function index()
    {
        // Récupérer tous les signalements
        $reports = Report::orderBy('created_at', 'desc')->paginate(10);

        return view('reports_index', compact('reports'));
    }

    // Afficher les détails d'un signalement
    public function show($id)
    {
        // Récupérer le signalement avec l'utilisateur associé
        $report = Report::with(['user'])->findOrFail($id);

        // Définir une variable pour le contenu
        $contenu = null;

        // Vérifier le type de contenu et récupérer le contenu associé
        switch ($report->content_type) {
            case 'Question':
                // Récupérer la question associée
                $contenu = Question::find($report->id_question);
                break;
            case 'support':
                // Récupérer le support associé
                $contenu = Support::find($report->id_support);
                break;
            case 'matiere':
                // Récupérer la matière associée
                $contenu = Matiere::find($report->id_Matiere);
                break;
            case 'notification':
                // Récupérer la notification associée
                $contenu = Notification::find($report->id_notification);
                break;
        }

        // Si le contenu est null (c'est-à-dire qu'il a été supprimé), afficher un message alternatif
        if ($contenu === null) {
            $contenu = 'Le contenu signalé a été supprimé ou n\'existe plus.';
        }

        // Passer le signalement et le contenu à la vue
        return view('admin_showreport', compact('report', 'contenu'));
    }

    // Marquer un signalement comme résolu
    public function resolve($id)
    {
        // Récupérer le signalement
        $report = Report::findOrFail($id);

        // Mettre à jour le statut du signalement
        $report->status = 'resolu';
        $report->save();

        // Rediriger vers la liste des signalements avec un message de succès
        return redirect()->route('admin.reports.index')->with('success', 'Signalement marqué comme résolu.');
    }

    // Rejeter un signalement
    public function reject($id)
    {
        // Récupérer le signalement
        $report = Report::findOrFail($id);

        // Mettre à jour le statut du signalement
        $report->status = 'rejete';
        $report->save();

        // Rediriger vers la liste des signalements avec un message de succès
        return redirect()->route('admin.reports.index')->with('success', 'Signalement rejeté.');
    }

    // Supprimer un signalement et le contenu associé
    public function destroy($id)
    {
        // Récupérer le signalement
        $report = Report::findOrFail($id);

        // Suppression du contenu associé selon le type
        switch ($report->content_type) {
            case 'Question':
                $content = Question::find($report->id_question);
                break;
            case 'support_educatifsz':
                $content = Support::find($report->id_support);
                break;
            case 'matiere':
                $content = Matiere::find($report->id_Matiere);
                break;
            case 'notification':
                $content = Notification::find($report->id_notification);
                break;
            default:
                $content = null;
        }

        // Si le contenu existe, le supprimer
        if ($content) {
            $content->delete();
        }

        // Supprimer le signalement
        $report->delete();

        // Rediriger vers la liste des signalements avec un message de succès
        return redirect()->route('admin.reports.index')->with('success', 'Signalement et contenu supprimés.');
    }
}
