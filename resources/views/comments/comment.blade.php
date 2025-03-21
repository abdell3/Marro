<div class="card mb-2">
    <div class="card-body">
        <p class="card-text">{{ $comment->content }}</p>
        <p class="card-text">
            <small class="text-muted">
                Commenté par {{ $comment->user->name }} le {{ $comment->created_at->format('d/m/Y H:i') }}
            </small>
        </p>

        
        <!-- <button class="btn btn-sm btn-link" onclick="toggleReplyForm({{ $comment->id }})">Répondre</button> -->

        
        <div id="replyForm{{ $comment->id }}" style="display: none;" class="mt-2">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="2" placeholder="Répondre à ce commentaire..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Envoyer</button>
            </form>
        </div>

        
        @if ($comment->replies->count() > 0)
            <div class="ml-4 mt-2">
                @foreach ($comment->replies as $reply)
                    @include('comments.comment', ['comment' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>


<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('replyForm' + commentId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>