<div class="question-detail">
    <div class="question-title">
        <img src="{{ $question->creator->getProfileImage() }}" alt="user">
        <div class="title">
            <h1> {{ $question->title }} </h1> 
            <div class="q-tags">@foreach ($question->tags as $tag)
            <span>{{ $tag->name }}</span>@endforeach</div>
        </div>
        
        @if (Auth::check())
            @if (Auth::user()->id === $question->user_id)
                <div class="question-dropdown">
                    <button>
                        <ion-icon name="ellipsis-vertical" class="purple"></ion-icon>
                    </button>
                    <div class="q-drop-content">
                        <div id="edit-question">
                            <ion-icon name="create"></ion-icon>
                            <span>Edit</span>
                        </div>
                        <a href="#">
                            <ion-icon name="time"></ion-icon>
                            <span>Post activity</span>
                        </a>
                        <div id="delete-question">
                            <ion-icon name="trash"></ion-icon>
                            <span>Delete</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="question-dropdown">
                    <button>
                        <ion-icon name="ellipsis-vertical" class="purple"></ion-icon>
                    </button>
                    <div class="q-drop-content">
                        <a href="#answerFormContainer">
                            <ion-icon name="pencil"></ion-icon>
                            <span>Answer</span>
                        </a>
                        <div>
                            <ion-icon name="bookmark"></ion-icon>
                            <span>Follow</span>
                        </div>
                        <a href="#">
                            <ion-icon name="time"></ion-icon>
                            <span>Post activity</span>
                        </a>
                        <div>
                            <ion-icon name="flag"></ion-icon>
                            <span>Report</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div> 

    <div class="question-t">
        <div class="vote-btns">
            @if (Auth::check())
                <button class="up-vote">
                    <ion-icon id="up" class= "{{ Auth::user()->hasVoted($question->id) && (Auth::user()->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}" name="caret-up" ></ion-icon>
                </button>
                <span>{{ $question->votes }}</span>
                <button class="down-vote">
                    <ion-icon id="down" class= "{{ ((Auth::user()->hasVoted($question->id)) && !Auth::user()->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} " name="caret-down" ></ion-icon>
                </button>
            @else 
                <button class="up-vote">
                    <ion-icon class="no-up notvoted" name="caret-up" ></ion-icon>
                </button>
                <span>{{ $question->votes }}</span>
                <button class="down-vote">
                    <ion-icon class="no-down notvoted" name="caret-down" ></ion-icon>
                </button>
            @endif
        </div>

        <div class="question-description"> 
            <ul>
                <li> <a href="{{ route('profile', ['id' => $question->creator->id ]) }}" class="purple">{{ $question->creator->name }}</a> asked {{ $question->timeDifference() }} ago</li>
                <li id="q-modi"> Modified {{ $question->lastModification() }} ago</li>
                <li> Viewed {{ $question->nr_views }} times </li>
                @if ($question->game)
                    <li> Game: <a href="{{ route('game', ['id' => $question->game->id]) }}" class="purple"> {{ $question->game->name }}</a></li>
                @endif
            </ul>
            <p>{{ $question->latestContent() }}</p>
           
            <div class="q-files">
                @foreach($question->documents() as $document)
                    <div class="q-file">
                        <ion-icon name="document"></ion-icon>
                        <a href="{{ asset('question/' . $document->file_name) }}" download="{{ asset('question/' . $document->file_name) }}">
                            <span>Document</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="q-img">
                @foreach($question->images() as $image)
                    <img src="{{ asset('question/' . $image->file_name) }}" alt="question-image">
                @endforeach
            </div>
        </div>
    </div>
</div>
