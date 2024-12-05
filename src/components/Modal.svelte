<script lang="ts">
  import { onMount } from 'svelte';

  export let movie: { 
    title: string; 
    image: string; 
    description: string; 
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
      const response = await fetch(`http://localhost:8080/api/get.php?movie_title=${encodeURIComponent(movie.title)}`);
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

    errorMessage = ""; // Reset error message

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
        await fetchComments(); // Re-fetch comments
      } else {
        errorMessage = data.error || "Something went wrong.";
      }
    } catch (error: unknown) {
      errorMessage = "Failed to post comment: " + (error instanceof Error ? error.message : "An unknown error occurred");
    }
  };

  // Fetch comments when the modal is mounted
  onMount(() => {
    fetchComments();
  });
</script>

<div class="modal-backdrop" on:click={onClose}>
  <div class="modal-content" on:click|stopPropagation>
    <!-- Close Button -->
    <button class="close-button" on:click={onClose}>×</button>

    <!-- Movie Details -->
    <h2 class="movie-title">{movie.title}</h2>
    <img src={movie.image} alt={movie.title} class="movie-image" />
    <p class="movie-description">{movie.description}</p>
    <p class="movie-rating">Rating: {movie.rating}</p>
    <a href={movie.imdbLink} target="_blank" class="movie-link">View on IMDb</a>

    <!-- Discussion Section -->
    <section class="discussion">
      <h3>Discussion</h3>
      <textarea
        bind:value={comment}
        placeholder="Write your comment here..."
        class="comment-input"
      ></textarea>
      <button on:click={addComment} class="comment-button">Post Comment</button>

      {#if errorMessage}
        <p class="error-message">{errorMessage}</p>
      {/if}

      <div class="comments">
        {#each comments as comment, i (comment.text)}
          <div class="comment" key={i}>{comment.text}</div>
        {/each}
      </div>
    </section>
  </div>
</div>

<style>
  /* Modal Backdrop */
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

  /* Modal Content */
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

  /* Close Button */
  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    background: transparent;
    font-size: 24px;
    cursor: pointer;
  }

  .close-button:hover {
    color: red;
  }

  /* Movie Title */
  .movie-title {
    font-size: 24px;
    margin-bottom: 10px;
  }

  /* Movie Image */
  .movie-image {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
  }

  /* Movie Description */
  .movie-description {
    font-size: 16px;
    margin-bottom: 10px;
  }

  /* Movie Rating */
  .movie-rating {
    font-size: 18px;
    margin-bottom: 10px;
  }

  /* Movie Link */
  .movie-link {
    color: #007bff;
    text-decoration: underline;
    margin-bottom: 20px;
    display: inline-block;
  }

  /* Discussion Section */
  .discussion {
    margin-top: 20px;
  }

  /* Comment Input */
  .comment-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px;
    resize: vertical;
    min-height: 100px;
    background-color: #fff;
    font-size: 14px;
  }

  /* Comment Button */
  .comment-button {
    background-color: #f81e1e;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
  }

  /* Comments Section */
  .comments {
    margin-top: 20px;
    max-height: 300px;
    overflow-y: auto;
  }

  /* Individual Comment */
  .comment {
    background-color: #f0f0f0;
    color: black;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
    font-size: 14px;
  }

  /* Error Message */
  .error-message {
    color: red;
    margin-top: 10px;
    font-size: 14px;
  }
</style>
