@extends('layout.parent')
@section('title', 'List User')

@section('main')
    <h3 class="text-center text-uppercase mt-3 text-danger">List Users</h3>
    <a href="{{route('users.create')}}" class="btn btn-info mb-4 text-light">Creat New User</a>
    <table class="table table-secondary ">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Mobile</th>
                <th scope="col">Email</th>
                <th scope="col" colspan="3" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{$user->firtName}}</td>
                    <td>{{$user->lastName}}</td>
                    <td>{{$user->mobile}}</td>
                    <td>{{$user->email}}</td>
                    <td class="text-info">
                        <a href="{{route('users.show',$user->id)}}" class="btn btn-info text-light"><i class="bi bi-eye"></i></a>
                    </td>
                    <td class="text-info">
                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning text-body-secondary"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    <td class="text-info">
                        <a href="" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
