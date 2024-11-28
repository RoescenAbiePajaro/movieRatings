<!--  -->
<script lang="ts">
  import { onMount } from 'svelte';
  export let movie: { 
    title: string; 
    image: string; 
    rating: string; 
    imdbLink: string; 
  };
  export let onClose: () => void;

  let comment = ""; // User's comment
  let comments: Array<{ text: string }> = []; // List of comments
  let errorMessage = ""; // Error message for invalid comment

  // Fetch existing comments for the movie
  const fetchComments = async () => {
    try {
      const response = await fetch(`http://localhost:8080/api/get.php?movie_title=${(movie.title)}`);
      const data = await response.json();
      if (Array.isArray(data)) {
        comments = data.map((item: any) => ({ text: item.comment }));
      } else {
        throw new Error('Failed to fetch comments');
      }
    } catch (error) {
      console.error(error);
      errorMessage = "Failed to load comments.";
    }
  };

  // Post a new comment
  const addComment = async () => {
    if (comment.trim() === "") {
      errorMessage = "Comment cannot be empty.";
      return;
    }

    // Reset error message before posting the comment
    errorMessage = "";

    try {
      const response = await fetch('http://localhost:8080/api/post.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ movie_title: movie.title, comment })
      });
      const data = await response.json();

      if (data.success) {
        comments = [...comments, { text: comment }];
        comment = ""; // Clear the input field
        // Re-fetch comments after posting
        fetchComments();
      } else {
        errorMessage = data.error || "Something went wrong.";
      }
    } catch (error: unknown) {
      if (error instanceof Error) {
        errorMessage = "Failed to post comment: " + error.message;
      } else {
        errorMessage = "Failed to post comment: An unknown error occurred";
      }
    }
  };

  // Fetch comments when the modal is opened
  onMount(() => {
    fetchComments();
  });
</script>

<!-- Modal Structure -->
<div class="modal-backdrop" on:click={onClose}>
  <div class="modal-content" on:click|stopPropagation>
    <button class="close-button" on:click={onClose}>×</button>
    <h2 class="movie-title">{movie.title}</h2>
    <img src={movie.image} alt={movie.title} class="movie-image" />
    <p class="movie-rating">Rating: {movie.rating}</p>
    <a href={movie.imdbLink} target="_blank" class="movie-link">View on IMDb</a>

    <section class="discussion">
      <h3>Discussion</h3>
      <textarea
        bind:value={comment}
        placeholder="Write your comment here..."
        class="comment-input"
      ></textarea>
      <button on:click={addComment} class="comment-button">Post Comment</button>

      {#if errorMessage}
        <p class="error-message">{errorMessage}</p> <!-- Display error message -->
      {/if}

      <div class="comments">
        {#each comments as comment, i}
          <div class="comment" key={i}>{comment.text}</div>
        {/each}
      </div>
    </section>
  </div>
</div>

<!-- Styles -->
<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
  }

  .modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    max-height: 80%;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
  }

  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    background: transparent;
    font-size: 24px;
    cursor: pointer;
  }

  .movie-title {
    font-size: 24px;
    margin-bottom: 10px;
  }

  .movie-image {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
  }

  .movie-rating {
    font-size: 18px;
    margin-bottom: 10px;
  }

  .movie-link {
    color: #007bff;
    text-decoration: underline;
    margin-bottom: 20px;
    display: inline-block;
  }

  .discussion {
    margin-top: 20px;
  }

  .comment-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px;
    resize: vertical;
    min-height: 100px;
    background-color: #fff; /* Ensure background is light */
  }

  .comment-input::placeholder {
    color: #888; /* Light gray placeholder for contrast */
  }

  .comment-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
  }

  .comments {
    margin-top: 20px;
    max-height: 300px;
    overflow-y: auto;
  }

  .comment {
    background-color: #f0f0f0; /* Light gray background */
    color: black; /* Black text */
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
    font-size: 14px;
  }

  .error-message {
    color: red;
    margin-top: 10px;
    font-size: 14px;
  }
</style>
