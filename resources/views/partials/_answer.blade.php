<div class="answer-details">
    <div class="vote-btns">
    
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
            <li> <a href="{{ route('profile', ['id' => $answer->creator->id ]) }}" class="purple">{{ $answer->creator->name }}</a> answered {{ $answer->time_difference() }} ago</li>
            <li class="a-modi"> Modified {{ $answer->lastModification() }} ago </li>
            <li> {{ $answer->comments->count() }} comments </li>
        </ul>
        <div class="answer-comments">
            <ul id="answer-comment-list">
                @foreach ($answer->comments as $comment)
                    <li>
                        <div>
                            <img src="../images/user.png" alt="user">
                            <a href="" class="purple">{{ $comment->user->name }}</a>
                        </div>
                        <p>
                            {{ $comment->latestContent() }}
                        </p>
                    </li>
                @endforeach
                <li>
                @auth
                    <form action="{{ route('store_comment') }}" method="post">
                        @csrf
                        <div class="comment-input">
                            <img src="../images/user.png" alt="user">
                            <input type="hidden" name="userId" id="userId" value="{{ $answer->user_id }}">
                            <input type="hidden" name="questionId" id="questionId" value="{{ $answer->question_id }}">
                            <input type="hidden" name="answerId" id="answerId" value="{{ $answer->id }}">
                            <input type="text" id="commentario" name="commentario" placeholder="Add new comment">
                            <button type="submit">
                                <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                            </button>
                        </div>
                    </form>
                @endauth
                </li>
            </ul>
        </div>
    </div>
</div>

