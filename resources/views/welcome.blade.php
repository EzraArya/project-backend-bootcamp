@extends('template')
@section('content')
<div class="d-flex gap-2">
    @forelse ($items as $item)
        <div class="card" style="width: 18rem;">
            @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="Image" class="card-img-top" style="max-width: 18rem; max-height: 18rem; object-fit:cover">
            @else
                No Image
            @endif
            <div class="card-body">
                <h5 class="card-title">{{$item->name}}</h5>
                <p class="card-text">Rp. {{$item->price}}</p>
                <p class="card-text">{{$item->stock}} in stock</p>

                @auth
                    <form action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="btn btn-success">Add to Cart</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login to Add</a>
                @endauth
            </div>
        </div>
    @empty
        <div>
            <h1>No items in stock</h1>
        </div>
    @endforelse
</div>
@endsection
