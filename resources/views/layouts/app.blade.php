<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Martin Video Games</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <livewire:styles />

</head>
<body class="bg-gray-900 text-white flex flex-col h-screen ">
    <header class="border-b border-gray-600">
        <nav class="container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
            <div class="flex flex-col lg:flex-row items-center">
                <a href="/" class='text-4xl text-color-white font-bold'>
                    IGDB API
                </a>


                {{-- <ul class="flex mt-4 lg:mt-0 flex-row items-center space-x-8 ml-0 lg:ml-16">
                    <li><a href="#" class="hover:text-gray-400">Games</a></li>
                    <li><a href="#" class="hover:text-gray-400">Review</a></li>
                    <li><a href="#" class="hover:text-gray-400">Comming soon</a></li>
                </ul> --}}

            </div>
            <div class="flex items-center justify-between mt-4 lg:mt-0">
                {{-- @todo fix search --}}
                {{-- <livewire:search-dropdown> --}}
                <div class="ml-4 flex items-center w-16 h-16 bg-color-none lg:bg-orange-200 wm-8 transform rotate-45 rounded-lg mx-auto justify-center">
                    <div class="flex items-center bg-yellow-400 w-12 h-12 rounded-full p-1">
                        <a href="#"><img src="/img/rtree.png" class="w8 transform -rotate-45"></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="border-t border-gray-600 bg-gray-800">
        <div class="container mx-auto py-4 px-4 flex items-center justify-center">
            Powered by Martin <a class="underline hover:text-gray-400" href="#">Using IGDB api</a>
        </div>
    </footer>
    <livewire:scripts />
    <script src="/js/app.js"></script>
    @stack('scripts')
</body>
</html>
