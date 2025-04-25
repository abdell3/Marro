<x-layout.app title="Modération">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold text-gray-800">Tableau de bord de modération</h1>
                    </div>
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <p class="text-gray-600 mb-6">Bienvenue dans le panneau de modération. Ici, vous pouvez gérer les signalements et modérer le contenu de la plateforme.</p>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xs font-medium text-blue-500 uppercase tracking-wider">Total des signalements</h3>
                                    <p class="text-2xl font-bold text-gray-800">{{ $reports->count() }}</p>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xs font-medium text-red-500 uppercase tracking-wider">Posts signalés</h3>
                                    <p class="text-2xl font-bold text-gray-800">{{ $reports->where('reportable_type', 'App\\Models\\Post')->count() }}</p>
                                </div>
                                <div class="bg-red-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xs font-medium text-amber-500 uppercase tracking-wider">Commentaires signalés</h3>
                                    <p class="text-2xl font-bold text-gray-800">{{ $reports->where('reportable_type', 'App\\Models\\Comment')->count() }}</p>
                                </div>
                                <div class="bg-amber-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reports Table -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Signalements récents</h2>
                        
                        @if($reports->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raison</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Signalé par</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($reports->take(10) as $report)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    #{{ $report->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $report->reportable_type === 'App\\Models\\Post' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800' }}">
                                                        {{ $report->reportable_type === 'App\\Models\\Post' ? 'Post' : 'Commentaire' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $report->type_report->type }}: {{ Str::limit($report->raison, 30) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $report->utilisateur->prenom }} {{ $report->utilisateur->nom }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $report->date->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('moderation.reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
                                                    <form action="{{ route('moderation.reports.handle', $report->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="ignore">
                                                        <button type="submit" class="text-gray-600 hover:text-gray-900 mr-3">Ignorer</button>
                                                    </form>
                                                    <form action="{{ route('moderation.reports.handle', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu?');">
                                                        @csrf
                                                        <input type="hidden" name="action" value="delete_content">
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($reports->count() > 10)
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:underline">Voir tous les signalements</a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <p class="text-gray-500">Aucun signalement à traiter. Tout est en ordre !</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Navigation rapide</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('moderation') }}" class="flex items-center text-red-600 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Tableau de bord
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderation.reported-posts') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Posts signalés
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderation.reported-comments') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Commentaires signalés
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Moderation Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Statistiques</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Types de signalements</h4>
                            <div class="space-y-2">
                                @php
                                    $reportTypeCounts = $reports->groupBy('type_report_id');
                                @endphp
                                
                                @foreach($reportTypeCounts as $typeId => $typeReports)
                                    @php
                                        $reportType = $typeReports->first()->type_report;
                                    @endphp
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">{{ $reportType->type }}</span>
                                        <span class="text-sm font-medium">{{ $typeReports->count() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Signalements par date</h4>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Aujourd'hui</span>
                                <span class="text-sm font-medium">{{ $reports->where('date', '>=', now()->startOfDay())->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Cette semaine</span>
                                <span class="text-sm font-medium">{{ $reports->where('date', '>=', now()->startOfWeek())->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Ce mois</span>
                                <span class="text-sm font-medium">{{ $reports->where('date', '>=', now()->startOfMonth())->count() }}</span>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Actions de modération</h4>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Contenu supprimé</span>
                                <span class="text-sm font-medium">{{ rand(10, 50) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Signalements ignorés</span>
                                <span class="text-sm font-medium">{{ rand(5, 30) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
