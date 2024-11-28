<script>
  import Modal from "./Modal.svelte";

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
    // Add more movies here
  ];

  let selectedMovie = null;

  const openModal = (movie) => {
    selectedMovie = movie;
  };

  const closeModal = () => {
    selectedMovie = null;
  };
</script>

<main>
  <section>
    <h1>Movies</h1>
    <div class="movie-grid">
      {#each movies as movie}
        <div class="movie-card" on:click={() => openModal(movie)}>
          <img src={movie.image} alt={movie.title} />
          <h3>{movie.title}</h3>
        </div>
      {/each}
    </div>
  </section>

  {#if selectedMovie}
    <Modal movie={selectedMovie} onClose={closeModal} />
  {/if}
</main>

<style>
  .movie-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 20px;
  }

  .movie-card {
    cursor: pointer;
    text-align: center;
  }

  .movie-card img {
    max-width: 100%;
    border-radius: 10px;
  }
</style>
