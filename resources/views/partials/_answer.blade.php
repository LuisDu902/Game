<div class="answer-details">
    <div class="vote-btns">
        @if (Auth::check())
            <button class="up-vote">
                <ion-icon id="up" class= "{{ Auth::user()->hasVoted($question->id) && (Auth::user()->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}" name="caret-up" ></ion-icon>
            </button>
            <span>{{ $answer->votes }}</span>
            <button class="down-vote">
                <ion-icon id="down" class= "{{ ((Auth::user()->hasVoted($question->id)) && !Auth::user()->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} " name="caret-down" ></ion-icon>
            </button>
        @else 
            <button class="up-vote">
                <ion-icon class="no-up notvoted" name="caret-up" ></ion-icon>
            </button>
            <span>{{ $answer->votes }}</span>
            <button class="down-vote">
                <ion-icon class="no-down notvoted" name="caret-down" ></ion-icon>
            </button>
        @endif
    </div>
    <div class="answer-content"> 
        <div>
            <img src="../images/user.png" alt="user">
            <p>
                {{ $answer->latestContent() }}
            </p>
            @if(Auth::check() and (Auth::id() == $answer->user_id))
                    <button class="edit-answer" data-id="{{ $answer->id }}">Edit</button>
            @endif
        </div>
        <ul>
            <li> <a href="{{ route('profile', ['id' => $answer->creator->id ]) }}" class="purple">{{ $answer->creator->name }}</a> answered {{ $answer->timeDifference() }} ago</li>
            <li class="a-modi"> Modified {{ $answer->lastModification() }} ago </li>
            <li> {{ $answer->comments->count() }} comments </li>
        </ul>
        <div class="answer-comments">
            <ul id="answer-comment-list">
                @if ($answer->comments->isNotEmpty())
                    @foreach ($answer->comments as $comment)
                        <li>
                            <div>
                                <img src="../images/user.png" alt="user">
                                <div class="c-desc">
                                    <a href="{{ route('profile', ['id' => $comment->user_id ]) }}" class="purple">{{ $comment->user->name }}</a>
                                    <span> {{ $comment->lastModification() }} ago </span>
                                </div>
                            </div>
                            <p>
                                {{ $comment->latestContent() }}
                            </p>
                        </li>
                    @endforeach
                @else
                    <li class="no-comment"> No comments yet, be the first to comment!</li>
                @endif
            </ul>
            @auth
                <div class="comment-input">
                    <img src="../images/user.png" alt="user">
                    <form>
                        <textarea name="content" id="c-content" class="form-control" placeholder="Enter your comment here..." required></textarea>
                        <div><button> Comment </button></div>
                    </form>
                </div>
            @endauth 
        </div>
    </div>
</div>

