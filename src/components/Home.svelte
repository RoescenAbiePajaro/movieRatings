<script>
    let movies = [
        {
            title: "John Wick (2014)",
            rating: "8.4",
            image: "assets/images/johnwick.jpg",
            imdbLink: "https://www.imdb.com/title/tt2911666/",
        },
        {
            title: "Transformer One",
            rating: "9.0",
            image: "assets/images/Transformers_One_Official_Poster.jpg",
            imdbLink: "https://www.imdb.com/title/tt8864596/",
        },
        {
            title: "Nobody",
            rating: "8.5",
            image: "assets/images/nobody.jpg",
            imdbLink: "https://www.imdb.com/title/tt7888964/",
        },
        {
            title: "Blade Runner",
            rating: "7.9",
            image: "assets/images/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg",
            imdbLink: "https://www.imdb.com/title/tt1856101/",
        },
        {
            title: "Ghost Rider",
            rating: "7.8",
            image: "assets/images/ghost.jpg",
            imdbLink: "https://www.imdb.com/title/tt1856101/",
        },
        {
            title: "The Platform",
            rating: "7.5",
            image: "assets/images/theplatform.jpg",
            imdbLink: "https://www.imdb.com/title/tt1856101/",
        },
        {
            title: "FaceOff",
            rating: "8.0",
            image: "assets/images/FaceOff.jpg",
            imdbLink: "https://www.imdb.com/title/tt1856101/",
        },
        {
            title: "Shuttered Island",
            rating: "8.0",
            image: "assets/images/shuttered.jpg",
            imdbLink: "https://www.imdb.com/title/tt1856101/",
        },
    ];

    let searchQuery = "";

    // Function to filter movies based on the search query
    $: filteredMovies = movies.filter((movie) =>
        movie.title.toLowerCase().includes(searchQuery.toLowerCase())
    );
</script>

<main class="flex flex-col flex-1 p-4 bg-black text-white min-h-screen">
    <!-- Search Bar -->
    <section class="py-4">
        <input
            type="text"
            bind:value={searchQuery}
            placeholder="Search movies..."
            class="w-full p-2 rounded-md border border-gray-700 bg-black text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500"
        />
    </section>

    <!-- Movie List -->
    <section class="py-8">
        <h2 class="text-center text-4xl font-bold mb-10">SMR Recommendation For You:</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            {#each filteredMovies as movie}
                <a href="{movie.imdbLink}" target="_blank" rel="noopener noreferrer">
                    <div class="group relative cursor-pointer overflow-hidden rounded-lg shadow-lg">
                        <img
                            src="{movie.image}"
                            alt="{movie.title}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center">
                            <h3 class="text-lg sm:text-xl font-bold mb-2">{movie.title}</h3>
                            <p class="text-base sm:text-lg bg-red-500 rounded-full px-4 py-1">{movie.rating}/10</p>
                        </div>
                    </div>
                </a>
            {/each}
        </div>

        {#if filteredMovies.length === 0}
            <p class="text-center text-xl mt-6">No movies found for "{searchQuery}".</p>
        {/if}
    </section>
</main>
