<tr class="user-info">
    <td><img src="../images/user.png" alt="User Image"></td>
    <td><a href="#">{{ $user->username }}</a></td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td class="{{ $user->rank }}">{{ $user->rank }}</td>
    <td>
    <select name="" class="status hidden {{ $user->is_banned ? 'banned' : 'active' }}" id="user-status" disabled data-user={{ $user->id }}>
        <option value="active" {{ $user->is_banned ? '' : 'selected' }}>Active</option>
        <option value="banned" {{ $user->is_banned ? 'selected' : '' }}>Banned</option>
    </select>
    </td>
</tr>