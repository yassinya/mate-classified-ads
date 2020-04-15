<div class="post">
    <a href="{{ route('ads.show.single', ['slug' => $ad->slug]) }}"><h6 class="post-title"><strong>{{ $ad->title }}</strong></h6></a>
        <p class="post-content">
            {{ mb_substr($ad->description, 0, 250) }} {{ strlen($ad->description) > 250 ? '...' : null }}
        </p>
        @if ($ad->images->count() > 0)
            <div class="images">
                @foreach ($ad->images->take(3) as $img)
                    <img src="{{ asset('storage/images/'.$img->sizes->where('type', 'mini_thumbnail')->first()->name) }}" alt="" data-full-size="{{ asset('storage/images/'.$img->sizes->where('type', 'original')->first()->name) }}" width="50">
                @endforeach
            </div>
            @endif
        <div class="footer">
            <div class="contact">
                <span><i class="fas fa-envelope"></i> {{ $ad->email }}</span>
                @if ($ad->phone_number)
                    <span><i class="fas fa-phone"></i> {{ $ad->phone_number }}</span>          
                @endif
            </div>
            <span class="badge badge-success">{{ ucfirst($ad->type->name) }}</span> 
            @if ($ad->created_at->startOfDay() == now()->startOfDay())
                <span class="badge badge-danger">TODAY</span>

            @else
            <span><i class="fas fa-clock"></i> <span style="font-size:13px;">{{ caRelativeDate($ad->created_at) }}</span></span>
            @endif
        </div>
</div>
