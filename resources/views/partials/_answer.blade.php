<div class="answer-details" id="answer{{ $answer->id }}" data-id="{{ $answer->id }}">
    <div class="vote-btns answer-btns" data-id="{{ $answer->id }}">
        @auth
            @if ($answer->user_id === Auth::user()->id)
                <button class="up-vote">
                    <ion-icon id="own-up" class= "notvoted" name="caret-up" onclick="showVoteWarning()"></ion-icon>
                </button>
                <span>{{ $answer->votes }}</span>
                <button class="down-vote">
                    <ion-icon id="own-down" class= "notvoted" name="caret-down" onclick="showVoteWarning()"></ion-icon>
                </button>
            @else
                <button class="up-vote">
                    <ion-icon id="a-up" class= "{{ Auth::user()->hasVoted('answer', $answer->id) && (Auth::user()->voteType('answer', $answer->id)) ? 'hasvoted' : 'notvoted' }}" name="caret-up" ></ion-icon>
                </button>
                <span>{{ $answer->votes }}</span>
                <button class="down-vote">
                    <ion-icon id="a-down" class= "{{ ((Auth::user()->hasVoted('answer', $answer->id)) && !Auth::user()->voteType('answer', $answer->id) ) ? 'hasvoted' : 'notvoted' }} " name="caret-down" ></ion-icon>
                </button>
            @endif
        @else 
            <button class="up-vote">
                <ion-icon class="no-up notvoted" name="caret-up" ></ion-icon>
            </button>
            <span>{{ $answer->votes }}</span>
            <button class="down-vote">
                <ion-icon class="no-down notvoted" name="caret-down" ></ion-icon>
            </button>
        @endauth
    </div>
    <div class="answer-content"> 
        <div class="a-content">
            <img class="answer-img" src="{{ $answer->creator->getProfileImage() }}" alt="user">
            <p>
                {{ $answer->latestContent() }}
            </p>
            @auth
                @if (Auth::user()->id === $answer->user_id)
                    <div class="answer-dropdown">
                        <button class="drop-btn">
                            <ion-icon name="ellipsis-vertical" onclick="toggleAnswerDropDown()"></ion-icon>
                        </button>
                        <div class="q-drop-content">
                            <div id="edit-answer" onclick="showEditAnswer()">
                                <ion-icon name="create"></ion-icon>
                                <span>Edit</span>
                            </div>
                            <div onclick="showAnswerDelete()">
                                <ion-icon name="trash"></ion-icon>
                                <span>Delete</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="answer-dropdown">
                        <button>
                            <ion-icon name="ellipsis-vertical" onclick="toggleAnswerDropDown()"></ion-icon>
                        </button>
                        <div class="q-drop-content">
                            <div>
                                <ion-icon name="flag"></ion-icon>
                                <span>Report</span>
                            </div>
                            @if (Auth::user()->id === $answer->question->user_id)
                                @if ($answer->is_correct)
                                    <div id="mark-answer" onclick="markAsWrong()">
                                        <ion-icon name="close-circle"></ion-icon>
                                        <span>Wrong</span>
                                    </div>
                                @else 
                                    <div id="mark-answer" onclick="markAsCorrect()">
                                        <ion-icon name="checkmark-circle"></ion-icon>
                                        <span>Correct</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        <div class="a-files">
            @foreach($answer->documents() as $document)
                <div class="a-file">
                    <ion-icon name="document"></ion-icon>
                    <a href="{{ asset('answer/' . $document->file_name) }}" download="{{ asset('answer/' . $document->file_name) }}">
                        <span>{{ $document->f_name }}</span>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="a-img">
            @foreach($answer->images() as $image)
                <img src="{{ asset('answer/' . $image->file_name) }}" alt="{{ $image->f_name }}" data-name="{{ $image->f_name }}">
            @endforeach
        </div>
        <ul>
            <li> <a href="{{ route('profile', ['id' => $answer->creator->id ]) }}" class="purple">{{ $answer->creator->name }}</a> answered {{ $answer->timeDifference() }} ago</li>
            <li class="a-modi"> Modified {{ $answer->lastModification() }} ago </li>
            <li class="comment-count"> {{ $answer->comments->count() }} comments </li>
            @if ($answer->is_correct)
                <li class="correct-answer">CORRECT ANSWER ✔</li>
            @endif
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
                    <img class="answer-img" src="{{ Auth::user()->getProfileImage() }}" alt="user">
                    <form>
                        <textarea name="content" id="c-content" class="form-control" placeholder="Enter your comment here..." required></textarea>
                        <div><button onclick="submitComment()"> Comment </button></div>
                    </form>
                </div>
            @endauth 
        </div>
    </div>
</div>

