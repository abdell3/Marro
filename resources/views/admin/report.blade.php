</x-admin-layout>

@section('content')
<div class="container py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Reports</h1>
        
        <div class="flex space-x-2">
            <a href="{{ route('admin.reports.pending') }}" class="px-3 py-1 rounded-lg {{ request()->routeIs('admin.reports.pending') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-100' : 'bg-white dark:bg-gray-800' }}">
                En attente
            </a>
            <a href="{{ route('admin.reports.approved') }}" class="px-3 py-1 rounded-lg {{ request()->routeIs('admin.reports.approved') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-100' : 'bg-white dark:bg-gray-800' }}">
                Approuvés
            </a>
            <a href="{{ route('admin.reports.rejected') }}" class="px-3 py-1 rounded-lg {{ request()->routeIs('admin.reports.rejected') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-100' : 'bg-white dark:bg-gray-800' }}">
                Rejetés
            </a>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Contenu
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Raison
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Auteur
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($reports as $report)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium line-clamp-1">
                                @if($report->reportable_type === 'App\Models\Post')
                                    <a href="{{ route('posts.show', $report->reportable->id) }}" class="hover:text-orange-500">
                                        {{ Str::limit($report->reportable->title, 50) }}
                                    </a>
                                @elseif($report->reportable_type === 'App\Models\Comment')
                                    <a href="{{ route('posts.show', $report->reportable->post->id) }}#comment-{{ $report->reportable->id }}" class="hover:text-orange-500">
                                        Commentaire: {{ Str::limit($report->reportable->content, 50) }}
                                    </a>
                                @elseif($report->reportable_type === 'App\Models\Community')
                                    <a href="{{ route('communities.show', $report->reportable->id) }}" class="hover:text-orange-500">
                                        Communauté: {{ $report->reportable->name }}
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $typeClass = [
                                    'App\Models\Post' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    'App\Models\Comment' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'App\Models\Community' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                ][$report->reportable_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeClass }}">
                                {{ class_basename($report->reportable_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                {{ $report->reason }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('users.show', $report->user->id) }}" class="hover:text-orange-500">
                                {{ $report->user->username }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $report->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'rejected' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                ][$report->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                @if($report->status === 'pending')
                                    En attente
                                @elseif($report->status === 'approved')
                                    Approuvé
                                @else
                                    Rejeté
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-orange-600 hover:text-orange-900 mr-3">
                                Voir
                            </a>
                            
                            @if($report->status === 'pending')
                                <button onclick="document.getElementById('approve-form-{{ $report->id }}').submit()" class="text-green-600 hover:text-green-900 mr-3">
                                    Approuver
                                </button>
                                <form id="approve-form-{{ $report->id }}" action="{{ route('admin.reports.handle', $report->id) }}" method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                </form>
                                
                                <button onclick="document.getElementById('reject-form-{{ $report->id }}').submit()" class="text-red-600 hover:text-red-900">
                                    Rejeter
                                </button>
                                <form id="reject-form-{{ $report->id }}" action="{{ route('admin.reports.handle', $report->id) }}" method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Aucun signalement trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $reports->links() }}
    </div>
</div>
</x-admin-layout>