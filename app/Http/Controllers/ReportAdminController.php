<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Question;  // Si tu veux accéder aux questions signalées
use App\Models\Answer;    // Si tu veux accéder aux réponses signalées
use App\Models\Support;   // Si tu veux accéder aux supports signalés
use Illuminate\Http\Request;

class ReportAdminController extends Controller
{
    // Afficher la liste des signalements
    public function index()
    {
        $reports = Report::all();
        return view('reports_index', compact('reports'));
    }

    // Marquer un signalement comme résolu
    public function resolve($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'resolved';  // Modifier le statut du signalement
        $report->save();

        return redirect()->route('reports.index')->with('success', 'Signalement marqué comme résolu.');
    }

    // Supprimer un signalement et le contenu associé
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        
        // Suppression du contenu associé selon le type de contenu signalé
        if ($report->content_type == 'question') {
            $content = Question::findOrFail($report->content_id);
            $content->delete();
        } elseif ($report->content_type == 'answer') {
            $content = Answer::findOrFail($report->content_id);
            $content->delete();
        } elseif ($report->content_type == 'support') {
            $content = Support::findOrFail($report->content_id);
            $content->delete();
        }

        // Supprimer le signalement après avoir supprimé le contenu
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Signalement et contenu supprimés.');
    }

    // Rejeter un signalement
    public function reject($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'rejected';  // Changer le statut du signalement à rejeté
        $report->save();

        return redirect()->route('reports.index')->with('success', 'Signalement rejeté.');
    }

    // Voir le contenu signalé
    public function viewContent($id)
    {
        $report = Report::findOrFail($id);
        $content = null;

        // Rediriger l'admin vers le contenu concerné selon le type de contenu
        if ($report->content_type == 'question') {
            $content = Question::findOrFail($report->content_id);
            return view('admin.questions.show', compact('content'));  // Page de la question
        } elseif ($report->content_type == 'answer') {
            $content = Answer::findOrFail($report->content_id);
            return view('admin.answers.show', compact('content'));  // Page de la réponse
        } elseif ($report->content_type == 'support') {
            $content = Support::findOrFail($report->content_id);
            return view('admin.supports.show', compact('content'));  // Page du support
        }

        return redirect()->route('reports.index')->with('error', 'Contenu non trouvé.');
    }

    // Contacter l'auteur du contenu signalé
    public function contactAuthor($id)
    {
        $report = Report::findOrFail($id);
        $content = null;

        // Récupérer l'auteur en fonction du type de contenu
        $author = null;
        if ($report->content_type == 'question') {
            $content = Question::findOrFail($report->content_id);
            $author = $content->user;
        } elseif ($report->content_type == 'answer') {
            $content = Answer::findOrFail($report->content_id);
            $author = $content->user;
        } elseif ($report->content_type == 'support') {
            $content = Support::findOrFail($report->content_id);
            $author = $content->user;
        }

        // Vérifier si l'auteur est trouvé
        if ($author) {
            // Ici, tu peux envoyer un email ou rediriger vers une page de contact
            // Exemple : envoi d'un email à l'auteur
            // Mail::to($author->email)->send(new ReportRejected($report));  // Exemple d'envoi d'email

            return view('reports.contactAuthor', compact('report', 'author'));
        }

        return redirect()->route('reports.contactAuthor')->with('error', 'Auteur non trouvé.');
    }
}
