@foreach ($users as $user)
    <p>
        <span style="color: red">Name: </span>{{ $user->firtName }} {{ $user->lastName }}
        <span style="color: red">Email: </span>{{ $user->email }}
    </p>
@endforeach
