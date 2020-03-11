<div class="post">
    <a href="{{ route('ads.show.single', ['slug' => $ad->slug]) }}"><h6 class="post-title"><strong>{{ $ad->title }}</strong></h6></a>
        <p class="post-content">
                {{ $ad->description }}
            <br>
            <i class="fas fa-envelope"></i> {{ $ad->email }}
            <br>  
            @if ($ad->phone_number)
                <i class="fas fa-phone"></i> {{ $ad->phone_number }}              
            @endif
        </p>
    <span class="badge badge-info ad-type">{{ ucfirst($ad->type->name) }} </span> <span class="badge badge-danger">TODAY</span>
</div>