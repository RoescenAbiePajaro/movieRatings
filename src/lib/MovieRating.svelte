<script>
  export let movieId;
  export let rating = 0;  // Current average rating
  let currentRating = 0;  // Local rating for the current session
  
  // Handle the user rating action
  function handleRating(star) {
    // Update the current rating
    currentRating = star;

    // Send the rating to the backend
    fetch('http://localhost:5000/rate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ movieId, rating: star }),
    })
      .then((response) => response.json())
      .then((data) => {
        // Update the average rating after the server responds
        rating = data.averageRating;
      })
      .catch((error) => console.error('Error:', error));
  }

  // Compute the class for each star (filled or empty)
  function getStarClass(starIndex) {
    return starIndex <= currentRating ? 'star-filled' : 'star-empty';
  }
</script>

<style>
  .stars {
    display: flex;
    gap: 5px;
    cursor: pointer;
  }

  .star {
    width: 30px;
    height: 30px;
    background-color: gray;
    clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
  }

  .star-filled {
    background-color: gold;
  }

  .star-empty {
    background-color: gray;
  }

  .average-rating {
    margin-top: 10px;
    font-size: 1.2rem;
  }
</style>

<div>
  <div class="stars">
    {#each [1, 2, 3, 4, 5] as star}
      <div
        class="star {getStarClass(star)}"
        on:click={() => handleRating(star)}
        on:mouseover={() => currentRating = star}
        on:mouseout={() => currentRating = rating} 
      ></div>
    {/each}
  </div>
  <div class="average-rating">
    Average Rating: {rating.toFixed(1)}
  </div>
</div>
