@extends('templates.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Ads</h1>
    <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-body">
                   @if($ads->count() > 0)
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th>Confirmed at</th>
                                <th>Suspended</th>
                                <th>Category</th>
                                <th>User ID</th>
                                <th>Created at</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($ads as $ad)
                                    <tr>
                                        <td>{{ $ad->id }}</td>
                                        <td>{{ mb_substr($ad->title, 0, 100) }}</td>
                                        <td>{{ $ad->email }}</td>
                                        <td>{{ $ad->confirmed_at ? \Carbon\Carbon::parse($ad->confirmed_at)->toDateString() : 'Not confirmed'  }}</td>
                                        <td>{{ $ad->is_suspended ? 'Yes' : 'No'  }}</td>
                                        <td>{{ $ad->category_id ? $ad->category->name : 'Unknown'  }}</td>
                                        <td>{{ $ad->user_id ? $ad->user_id : 'Posted by guest' }}</td>
                                        <td>{{ $ad->created_at->toDateString() }}</td>
                                        <td><a href="{{ route('ads.show.single', ['slug' => $ad->slug]) }}">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                                {{ $ads->links() }}
                        </div>
                    @else
                    <p class="text-center">There are no registered ads</p>
                    @endif
               </div>
           </div>
       </div>
    </div>
</div>

@endsection
