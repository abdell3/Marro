<x-layouts.app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Poll') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">{{ $poll->question }}</h1>
                    
                    @if($poll->expires_at && $poll->expires_at->isPast())
                        <div class="mb-4 p-2 bg-yellow-100 text-yellow-800 rounded-md">
                            This poll has ended on {{ $poll->expires_at->format('M d, Y H:i') }}
                        </div>
                    @elseif($poll->expires_at)
                        <div class="mb-4 text-sm text-gray-500">
                            Poll ends on {{ $poll->expires_at->format('M d, Y H:i') }}
                        </div>
                    @endif
                    
                    @php
                        $totalVotes = $poll->options->sum('votes');
                        $hasVoted = Auth::check() && $poll->options()->whereHas('voters', function($query) {
                            $query->where('user_id', Auth::id());
                        })->exists();
                    @endphp
                    
                    @if($hasVoted || ($poll->expires_at && $poll->expires_at->isPast()))
                        <!-- Show results -->
                        <div class="space-y-4">
                            @foreach($poll->options as $option)
                                @php
                                    $percentage = $totalVotes > 0 ? round(($option->votes / $totalVotes) * 100) : 0;
                                    $isVoted = Auth::check() && $option->voters->contains(Auth::id());
                                @endphp
                                <div class="border border-gray-200 rounded-md p-3">
                                    <div class="flex justify-between mb-1">
                                        <span class="font-medium {{ $isVoted ? 'text-orange-500' : '' }}">
                                            {{ $option->text }} {{ $isVoted ? '(Your vote)' : '' }}
                                        </span>
                                        <span class="text-gray-600">{{ $option->votes }} votes ({{ $percentage }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-sm text-gray-500">
                            Total votes: {{ $totalVotes }}
                        </div>
                    @else
                        <!-- Show voting form -->
                        <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                @foreach($poll->options as $option)
                                    <div class="flex items-center">
                                        <input type="radio" id="option_{{ $option->id }}" name="option_id" value="{{ $option->id }}" class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300">
                                        <label for="option_{{ $option->id }}" class="ml-2 block text-gray-700">
                                            {{ $option->text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            @error('option_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            
                            <div class="mt-6">
                                @auth
                                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                        Vote
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> to vote in this poll.
                                @endauth
                            </div>
                        </form>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('posts.show', $poll->post_id) }}" class="text-blue-500 hover:underline">
                            &larr; Back to post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>