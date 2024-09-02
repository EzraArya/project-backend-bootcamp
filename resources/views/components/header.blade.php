<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('home')}}">Item Manager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          @if (Auth::check())
            @if (Auth::user()->is_admin)
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('items.index')}}">Item</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('invoice.display') }}">Invoice</a>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('invoices.index') }}">Invoice</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('carts.index')}}">Cart</a>
              </li>
            @endif
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link">Logout</button>
              </form>
           </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>