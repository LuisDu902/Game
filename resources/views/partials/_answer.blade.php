<div class="answer-details">
    <div class="vote-btns">
    
    </div>
    <div class="answer-content"> 
        <div>
            <img src="../images/user.png" alt="user">
            <p>
                {{ $answer->latest_content() }}
            </p>
        </div>
        <ul>
            <li> <a href="{{ route('profile', ['id' => $answer->creator->id ]) }}" class="purple">{{ $answer->creator->name }}</a> answered {{ $answer->time_difference() }} ago</li>
            <li> Modified {{ $answer->last_modification() }} ago </li>
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
                            {{ $comment->latest_content() }}
                        </p>
                    </li>
                @endforeach
                <li>
                    <div class="comment-input">
                        <img src="../images/user.png" alt="user">
                        <input type="text" placeholder="Add new comment">
                        <button>
                            <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>