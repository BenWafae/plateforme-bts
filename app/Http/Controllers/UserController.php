<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roleFilter = $request->input('role'); // Get role from query parameter
        $users = User::when($roleFilter, function ($query, $roleFilter) {
                        return $query->where('role', $roleFilter);
                    })
                    ->paginate(8)
                    ->appends(['role' => $roleFilter]);  // Ajoute le filtre à l'URL de la pagination
    
        return view('users_index', compact('users', 'roleFilter'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form_users');
        // retourner la vue qui contient le form_userrrs
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'nom' => 'required|string|min:2|max:255',
           'prenom' => 'required|string|min:2|max:255',
           'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255',
            'role' => 'required|in:administrateur,professeur,etudiant'

        ]);
        User::create([
            'nom' => $request->nom,
            'prenom' => $request ->prenom,
            'email' =>$request ->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,

        ]);
        return redirect()->route('user.index')->with('success', 'Utilisateur ajouté avec succès.');
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
        {
            // Récupérer l'utilisateur par son ID
            $user = User::findOrFail($id);
            
            // Retourner la vue d'édition avec l'utilisateur
            return view('users_edit', compact('user'));
        }
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
        // Valider les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id_user', // Assurez-vous que l'email est unique sauf pour l'utilisateur actuel
            'password' => 'nullable|string|min:8|confirmed', // Le mot de passe est optionnel, mais si fourni, doit être confirmé
        ]);

        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);
        
        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password, // Si un mot de passe est fourni, il est crypté
        ]);

        // Rediriger l'utilisateur avec un message de succès
        return redirect()->route('user.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    
    // Supprimer l'utilisateur
    $user->delete();

    // Rediriger avec un message de succès
    return redirect()->route('user.index')->with('success', 'Utilisateur supprimé avec succès!');
}
    }

