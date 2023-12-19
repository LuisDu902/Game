<tr class="report-info" id="report{{ $report->id }}" data-id="{{ $report->id }}">
<td><img src="{{ $report->reported->getProfileImage() }}" alt="User Image"></td>    
<td>{{ $report->reporter->name }}</td> <!-- assuming 'name' is the attribute -->
    <td>{{ $report->reported->name }}</td> <!-- replace 'name' with the actual attribute -->
    <td>{{ $report->reason }}</td>
    <td>{{ $report->explanation }}</td>
    <td>
        <select name="status" class="status {{ $report->is_solved ? 'solved' : 'unsolved' }}" data-report="{{ $report->id }}" onchange="changeReportStatus(this)">
            <option value="1" {{ $report->is_solved ? 'selected' : '' }}>Solved</option>
            <option value="0" {{ !$report->is_solved ? 'selected' : '' }}>Unsolved</option>
        </select>
    </td>

</tr>
