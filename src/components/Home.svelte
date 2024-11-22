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
            rating: "8.5",
            image: "assets/images/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg",
            imdbLink: "https://www.imdb.com/title/tt0083658/",
        },
    ];
</script>
<main class="flex flex-col flex-1 p-4 bg-black text-white min-h-screen">
    <section class="py-8">
        <h2 class="text-center text-4xl font-bold mb-10">SMR Recommendation For You:</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            {#each movies as movie}
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
    </section>
</main>
