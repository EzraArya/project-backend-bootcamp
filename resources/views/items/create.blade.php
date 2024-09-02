@extends('template')
@section('content')
    <form action="{{route('items.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="item-name" class="form-label">Item name</label>
            <input type="text" class="form-control" id="item-name" aria-describedby="emailHelp" name="name">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="item-price" class="form-label">Price </label>
            <input type="number" class="form-control" id="item-price" aria-describedby="emailHelp" name="price">
            @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="item-stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="item-stock" aria-describedby="emailHelp" name="stock">
            @error('stock')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="formFile" name="image_path">
            @error('image_path')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection