@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Tableau de bord</h1>

        <!-- Statistiques sous forme de cartes horizontales -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Nombre total d'étudiants -->
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.104 0 2 .896 2 2s-.896 2-2 2-2-.896-2-2 .896-2 2-2zm0 4c.554 0 1-.446 1-1s-.446-1-1-1-1 .446-1 1 .446 1 1 1zM4 12c.246 0 .481-.116.641-.311.637-.855 1.562-1.689 2.79-2.274-.073-.124-.143-.254-.214-.39C5.546 8.078 4 9.998 4 12zm16 0c0-1.378-.657-2.582-1.656-3.265-.396.283-.825.585-1.28.907.15.045.307.083.459.132 1.27.222 2.398.807 3.242 1.557-.11.102-.23.211-.34.313-.057.056-.119.111-.181.167-.112.111-.226.223-.338.337-.077-.082-.145-.168-.224-.253-.381-.381-.717-.738-1.02-1.104-.15-.211-.303-.42-.458-.63-.103-.157-.209-.315-.318-.472C17.896 9.264 16 11.009 16 13h1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre d'étudiants</h2>
                    <p class="text-2xl">{{ $studentsCount }}</p>
                </div>
            </div>

            <!-- Nombre total de professeurs -->
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l7 7 7-7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre de professeurs</h2>
                    <p class="text-2xl">{{ $professorsCount }}</p>
                </div>
            </div>

            <!-- Nombre total de supports -->
            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 3h-4.586a1 1 0 0 0-.707.293L11 5.586 9.293 3.707A1 1 0 0 0 8 3H3a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre de supports</h2>
                    <p class="text-2xl">{{ $supportsCount }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

