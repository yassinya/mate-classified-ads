<div class="post">
    <a href="{{ route('ads.show.single', ['slug' => $ad->slug]) }}"><h6 class="post-title"><strong>{{ $ad->title }}</strong></h6></a>
        <p class="post-content">
            {{ mb_substr($ad->description, 0, 250) }} {{ strlen($ad->description) > 250 ? '...' : null }}
        </p>
        <div class="footer">
            <div class="contact">
                <span><i class="fas fa-envelope"></i> {{ $ad->email }}</span>
                @if ($ad->phone_number)
                    <span><i class="fas fa-phone"></i> {{ $ad->phone_number }}</span>          
                @endif
            </div>
            <span class="badge badge-success">{{ ucfirst($ad->type->name) }}</span> 
            <span class="badge badge-danger">TODAY</span>
        </div>
</div>