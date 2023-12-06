<li>
    <div>
        <img src="{{ $comment->creator->getProfileImage() }}" alt="user">
        <div class="c-desc">
            <a href="{{ route('profile', ['id' => $comment->user_id ]) }}" class="purple">{{ $comment->user->name }}</a>
            <span> {{ $comment->lastModification() }} ago </span>
        </div>
        @auth
            @if (Auth::user()->id === $comment->user_id)
                <div class="comment-dropdown">
                    <button class="drop-btn">
                        <ion-icon name="ellipsis-vertical" onclick="toggleCommentDropDown()"></ion-icon>
                    </button>
                    <div class="q-drop-content">
                        <div id="edit-question">
                            <ion-icon name="create"></ion-icon>
                            <span>Edit</span>
                        </div>
                        <div>
                            <ion-icon name="trash"></ion-icon>
                            <span>Delete</span>
                        </div>
                    </div>
                </div>
            @else
            <div class="comment-dropdown">
                <button>
                    <ion-icon name="ellipsis-vertical" onclick="toggleCommentDropDown()"></ion-icon>
                </button>
                <div class="q-drop-content">
                    <div>
                        <ion-icon name="flag"></ion-icon>
                        <span>Report</span>
                    </div>
                </div>
            </div>
            @endif
        @endauth
    </div>
    <p>
        {{ $comment->latestContent() }}
    </p>
</li>