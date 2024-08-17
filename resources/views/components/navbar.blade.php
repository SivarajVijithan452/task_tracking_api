<!-- resources/views/components/navbar.blade.php -->
<!-- Link to Vite for CSS assets -->
@vite('resources/css/app.css')
<!-- Add FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="navbar bg-base-100">
  <div class="navbar-start font-bold">
    <a href="{{ url('dashboard') }}" class="btn btn-ghost normal-case text-xl">Simple Task Tracker</a>
  </div>
  <div class="navbar-end flex items-center space-x-4">
    @auth
      <!-- Display the username and a small logout button -->
      <div class="flex items-center">
        <span class="text-sm font-medium text-gray-700 mr-4">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="btn btn-error btn-sm flex items-center">
            <i class="fas fa-sign-out-alt mr-1"></i> Logout
          </button>
        </form>
      </div>
    @else
      <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
      <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
    @endauth
  </div>
</div>
