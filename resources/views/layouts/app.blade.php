<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="text-gray-900 bg-gray-200">
        <div id="app">
            <nav class="bg-white shadow-sm">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center py-2">

                        <h1>
                            <a class="transition ease-in-out duration-200 text-teal-400 hover:text-teal-200 flex items-center" href="{{ url('/projects') }}">
                                @include("svg.logo")
                                <span class="text-gray-700 font-sans text-2xl ml-2">{{ config('app.name') }}</span>
                            </a>
                        </h1>

                        <div>
                            <div class="ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @if (Route::has('register'))
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                @else
                                    <dropdown-component align="right">
                                        <template v-slot:trigger>
                                            <button class="flex items-center text-sm focus:outline-none">
                                                <img
                                                    class="w-8 rounded-full"
                                                    src="{{ gravatar_url(Auth::user()->email) }}"
                                                    alt="{{ Auth::user()->name }}'s avatar"
                                                >
                                                <span class="ml-2">
                                                    {{ Auth::user()->name }}
                                                </span>
                                            </button>
                                        </template>

                                        <template v-slot:default>
                                            <form id="logout-form" method="POST" action="/logout">
                                                @csrf
                                                <button class="dropdown-menu-item">Logout</button>
                                            </form>
                                        </template>
                                    </dropdown>

                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="py-4 container mx-auto">
                @yield('content')
            </main>
        </div>
    </body>
</html>
