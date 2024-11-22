<!-- <!-- moviepage.svelte  -->
 <script>
    import { onMount, getContext } from 'svelte';
    
    let { id } = getContext('params');
    let movie = {title:'',name:'', };
    let rating = 0;

    // Fetch movie data (GET request)
    onMount(async () => {
        const res = await fetch(`/api/movies/${id}`);
        movie = await res.json();
    });

    // Submit rating (POST request)
    const submitRating = async () => {
        const res = await fetch(`/api/movies/${id}/rate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ rating }),
        });
        if (res.ok) {
            alert('Rating submitted!');
        } else {
            alert('Failed to submit rating');
        }
    };
</script>

<main class="flex flex-col p-4 bg-black text-white min-h-screen">
    <section class="py-8">
        <h2 class="text-center text-4xl font-bold mb-10">{movie.title}</h2>
        <div class="flex justify-center mb-4">
            <img src={movie.image} alt={movie.title} class="w-64 h-96 object-cover" />
        </div>

        <div class="text-center mb-4">
            <h3 class="text-xl">Rate this movie</h3>
            <div class="flex justify-center space-x-2 mt-4">
                {#each [1, 2, 3, 4, 5] as num}
                    <button 
                        class="text-yellow-500"
                        on:click={() => rating = num}>
                        {num}★
                    </button>
                {/each}
            </div>
        </div>

        <div class="text-center mt-4">
            <button on:click={submitRating} class="bg-red-500 text-white px-6 py-2 rounded-full">
                Submit Rating
            </button>
        </div>
    </section>
</main>
