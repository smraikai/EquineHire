<h1>Business Details</h1>

<p>Name: {{ $business->name }}</p>
<p>Description: {{ $business->description }}</p>
<!-- Display other business details -->

<a href="{{ route('admin.index') }}">Back to Admin Dashboard</a>
