@extends('template')
@section('content')
    <a href="{{route('items.create')}}" class="btn btn-success">Add Item</a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Stock</th>
            <th scope="col">Category</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <td>
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="Image" style="width: 100px; height: auto;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->stock}}</td>
                    <td>{{$item->category->name}}</td>
                    <td>
                        <div class="d-flex flex-col justify-between gap-2">
                            <a href="{{route('items.edit', $item->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('items.destroy', $item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        Empty Table
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection