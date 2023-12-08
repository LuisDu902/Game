
@if ($users->count() > 0)
    <table class="users-table">
        <thead>
            <tr>
                <th></th> <th>Username</th>
                <th>Name</th> <th>Email Address</th>
                <th>Rank</th> <th>Status</th>
                <th>Delete User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <x-userinfo :user="$user"/>               
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@else
    <div class="no-records">
        <img src="{{ asset('images/nothing.png') }}" alt="nothing">
        <span>No matching users</span>
    </div>
@endif