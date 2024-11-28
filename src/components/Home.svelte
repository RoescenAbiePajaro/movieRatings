<script>
  import Modal from "./Modal.svelte";

  let searchTerm = '';
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
      title: "Nobody",
      rating: "8.5",
      image: "assets/images/nobody.jpg",
      imdbLink: "https://www.imdb.com/title/tt7888964/",
    },
    {
      title: "Nobody",
      rating: "8.5",
      image: "assets/images/nobody.jpg",
      imdbLink: "https://www.imdb.com/title/tt7888964/",
    },
    {
      title: "Nobody",
      rating: "8.5",
      image: "assets/images/nobody.jpg",
      imdbLink: "https://www.imdb.com/title/tt7888964/",
    },
    {
      title: "Nobody",
      rating: "8.5",
      image: "assets/images/nobody.jpg",
      imdbLink: "https://www.imdb.com/title/tt7888964/",
    },
  ];

  let selectedMovie = null;

  const openModal = (movie) => {
    selectedMovie = movie;
  };

  const closeModal = () => {
    selectedMovie = null;
  };

  // Filter movies based on the search term
  $: filteredMovies = movies.filter((movie) =>
    movie.title.toLowerCase().includes(searchTerm.toLowerCase())
  );
</script>

<main>
  <section class="movies-section">
    <h1>SMR RECCOMENDATION FOR YOU</h1>

    <!-- Search bar -->
    <input 
      type="text" 
      placeholder="Search movies..." 
      bind:value={searchTerm}
      class="search-bar"
    />

    <!-- Movie Grid -->
    <div class="movie-grid">
      {#each filteredMovies as movie}
        <div class="movie-card" on:click={() => openModal(movie)}>
          <img src={movie.image} alt={movie.title} />
          <h3>{movie.title}</h3>
          <p>{movie.rating}</p>
        </div>
      {/each}
    </div>
  </section>

  {#if selectedMovie}
    <Modal movie={selectedMovie} onClose={closeModal} />
  {/if}
</main>

<style>
  /* Main section styles */
  .movies-section {
    padding: 20px;
    text-align: center;
  }

  h1 {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #333;
  }

  /* Search bar styles */
  .search-bar {
    padding: 12px;
    margin-bottom: 20px;
    width: 100%;
    max-width: 500px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #1e1e1e;
    color: #fff;
    outline: none;
  }

  .search-bar:focus {
    border-color: #007bff;
  }

  /* Movie grid layout */
  .movie-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    justify-items: center;
  }

  .movie-card {
    cursor: pointer;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }

  .movie-card img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    transition: transform 0.3s ease;
  }

  .movie-card img:hover {
    transform: scale(1.05);
  }

  .movie-card h3 {
    font-size: 1.1rem;
    margin: 10px 0;
    color: #333;
  }

  .movie-card p {
    font-size: 1rem;
    color: #666;
  }

</style>
