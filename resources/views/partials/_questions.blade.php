@if ($questions->count() > 0)
    <ul class="questions">
        @foreach($questions as $question)
            <li class="question-card"  id={{ $question->id }}>
                <div class="q-stats">
                    <span>{{ $question->votes }} votes</span>
                    <span>{{ $question->answers->count() }} answers</span>
                    <span>{{ $question->nr_views }} views</span>
                </div>
                <div class="q-content">
                    <a href="{{ route('question', ['id' => $question->id]) }}">
                        <h2>{{ $question->title }}</h2>
                    </a>

                    @if (strlen($question->latest_content()) >= 300)
                        <p>{{ substr($question->latest_content(), 0, 300) }}...</p>
                    @else
                        <p>{{ $question->latest_content() }}</p>
                    @endif
                    <span><a href="{{ route('profile', ['id' => $question->creator->id ]) }}" class="purple">{{ $question->creator->username }}</a> asked {{ $question->timeDifference() }} ago</span>
                </div>
                @if(Auth::check() and (Auth::id() == $question->creator->id) and Auth::user()->is_admin)
                    <div class="q-delete">
                        <button class="delete-button" onclick="deleteQuestion({{ $question->id }})">Delete</button>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    {{ $questions->links() }}
@else
    <div class="no-questions">
        <img class="no-questions-image" src="{{ asset('images/pikachuConfused.png') }}" alt="Psyduck Image">
        <p>No questions yet.</p>
    </div>
@endif