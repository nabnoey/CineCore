<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการหนังทั้งหมด</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">
    @include('components.navbar')

    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold text-center mb-8">
            <span class="inline-block p-4 rounded-full bg-gray-200 shadow-lg">🎥</span>
            <span class="text-gray-700">รายการหนังทั้งหมด</span>
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($movies as $movie)
                <a href="/movies/{{ $movie->id }}" class="card bg-gray-50 shadow-md rounded-xl overflow-hidden transition-transform duration-300 hover:scale-105">
                    <figure>
                        <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover">
                    </figure>
                    <div class="card-body p-4 bg-gray-50">
                        <h2 class="card-title text-lg font-semibold text-gray-800">{{ $movie->title }}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
