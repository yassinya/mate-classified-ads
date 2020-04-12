@extends('templates.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Users</h1>
    <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-body">
                   @if($users->count() > 0)
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>Joined at</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number ? $user->phone_number : 'Unknown' }}</td>
                                        <td>{{ $user->created_at->toDateTimeString() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                                {{ $users->links() }}
                        </div>
                    @else
                    <p class="text-center">There are no registered users</p>
                    @endif
               </div>
           </div>
       </div>
    </div>
</div>

@endsection
