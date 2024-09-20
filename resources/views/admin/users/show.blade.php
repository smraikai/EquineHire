<h1>User Details</h1>

<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<!-- Display other user details -->

<a href="{{ route('admin.index') }}">Back to Admin Dashboard</a>
