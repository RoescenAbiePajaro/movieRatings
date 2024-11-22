<!-- Home.svelte -->
<script>
    import { Link } from 'svelte-routing';
    

    let movies = [
        {
            id: 1,
            title: "John Wick(2014)",
            rating: "8.8",
            image: "/assets/images/johnwick.jpg",
            description: "An ex-hitman comes out of retirement to track down the gangsters that killed his dog and took everything from him."
        },
        {
            id: 2,
            title: "Transformer One",
            rating: "8.6",
            image: "/assets/images/Transformers_One_Official_Poster.jpg",
            description: "The battle between Autobots and Decepticons continues."
        },
        {
            id: 3,
            title: "Nobody",
            rating: "9.0",
            image: "/assets/images/nobody.jpg",
            description: "A family man who is overlooked and underestimated unleashes his fury on those who wronged him."
        },
        {
            id: 4,
            title: "Blade Runner",
            rating: "8.5",
            image: "/assets/images/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg",
            description: "A blade runner must pursue and terminate four replicants who stole a ship in space and have returned to Earth."
        },
    ];
</script>

<main class="flex flex-col flex-1 p-4 bg-black text-white min-h-screen">
    <section class="py-8">
        <h2 class="text-center text-4xl font-bold mb-10">Movie Ratings</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            {#each movies as movie}
                <a href={`/movie/${movie.id}`} class="group relative cursor-pointer overflow-hidden rounded-lg shadow-lg">
                    <img
                        src={movie.image}
                        alt={movie.title}
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center">
                        <h3 class="text-lg sm:text-xl font-bold mb-2">{movie.title}</h3>
                        <p class="text-base sm:text-lg bg-red-500 rounded-full px-4 py-1">{movie.rating}/10</p>
                    </div>
                </a>
            {/each}
        </div>
    </section>
</main>

