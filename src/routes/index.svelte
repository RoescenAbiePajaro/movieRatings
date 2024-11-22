<script>
    import { onMount } from 'svelte';
    import MovieRating from '../lib/MovieRating.svelte';
    let movies = [];
  
    onMount(() => {
      fetch('http://localhost:5000/movies')
        .then((res) => res.json())
        .then((data) => {
          movies = data;
        });
    });
  </script>
  
  <style>
    .movie-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin: 20px;
    }
    .movie-card {
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }
    .movie-card img {
      max-width: 100%;
      border-radius: 8px;
    }
    .movie-name {
      font-size: 1.5rem;
      font-weight: bold;
    }
  </style>
  
  <div class="movie-container">
    {#each movies as movie}
      <div class="movie-card">
        <img src={`/images/${movie.image}`} alt={movie.name} />
        <div class="movie-name">{movie.name}</div>
        <MovieRating {movie} rating={movie.averageRating} movieId={movie.id} />
      </div>
    {/each}
  </div>
  