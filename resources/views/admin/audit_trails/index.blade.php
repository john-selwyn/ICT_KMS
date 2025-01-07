<table>
    <thead>
        <tr>
            <th>Action</th>
            <th>Performed By</th>
            <th>Affected User</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($auditTrails as $auditTrail)
            <tr>
                <td>{{ $auditTrail->action }}</td>
                <td>{{ $auditTrail->performed_by_user_name }}</td>
                <td>{{ $auditTrail->affected_user_name }}</td>
                <td>{{ $auditTrail->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>