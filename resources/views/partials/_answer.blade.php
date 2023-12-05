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
        <div class="a-content">
            <img src="{{ $answer->creator->getProfileImage() }}" alt="user">
            <p>
                {{ $answer->latestContent() }}
            </p>
            @auth
                @if (Auth::user()->id === $answer->user_id)
                    <div class="answer-dropdown">
                        <button class="drop-btn">
                            <ion-icon name="ellipsis-vertical"></ion-icon>
                        </button>
                        <div class="q-drop-content">
                            <a href="#" id="edit-question">
                                <ion-icon name="create"></ion-icon>
                                <span>Edit</span>
                            </a>
                            <div>
                                <ion-icon name="trash"></ion-icon>
                                <span>Delete</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="answer-dropdown">
                        <button>
                            <ion-icon name="ellipsis-vertical"></ion-icon>
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
        <ul>
            <li> <a href="{{ route('profile', ['id' => $answer->creator->id ]) }}" class="purple">{{ $answer->creator->name }}</a> answered {{ $answer->timeDifference() }} ago</li>
            <li class="a-modi"> Modified {{ $answer->lastModification() }} ago </li>
            <li> {{ $answer->comments->count() }} comments </li>
        </ul>
        <div class="answer-comments">
            <ul class="answer-comment-list">
                @if ($answer->comments->isNotEmpty())
                    @foreach ($answer->comments as $comment)
                        @include('partials._comment', ['comment' => $comment])
                    @endforeach
                @else
                    <li class="no-comment"> No comments yet, be the first to comment!</li>
                @endif
            </ul>
            @auth
                <div class="comment-input">
                    <img src="{{ Auth::user()->getProfileImage() }}" alt="user">
                    <form>
                        <textarea name="content" id="c-content" class="form-control" placeholder="Enter your comment here..." required></textarea>
                        <div><button> Comment </button></div>
                    </form>
                </div>
            @endauth 
        </div>
    </div>
</div>

