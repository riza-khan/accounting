<h1>
    Users page
</h1>

@foreach ($users as $user)
<li>{{ $user->name }}</li>
@endforeach
