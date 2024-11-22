<script>
    export let movie;
  </script>
  
  <div>
    <h1>{movie.name}</h1>
    <img src={`/images/${movie.image}`} alt={movie.name} />
    <p>Average Rating: {movie.averageRating}</p>
  </div>
  