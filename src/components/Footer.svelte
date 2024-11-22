<script lang="ts">
    import { onMount } from 'svelte';

    // Define the type of each comment
    interface Comment {
        username: string;
        comment: string;
        timestamp: string; // Keep it as a string, or convert it into Date if needed
    }

    // Define comments as an array of Comment objects
    let comments: Comment[] = [];
    let username = '';
    let comment = '';
    let errorMessage = '';
    let successMessage = '';

    // Fetch comments from the backend
    onMount(async () => {
        try {
            const res = await fetch('http://localhost/movie_ratings/get_comments.php');
            if (!res.ok) {
                throw new Error('Failed to fetch comments');
            }
            comments = await res.json();
        } catch (error: unknown) {
            if (error instanceof Error) {
                errorMessage = error.message;
            } else {
                errorMessage = 'An unknown error occurred';
            }
        }
    });

    // Submit comment
    const submitComment = async () => {
        try {
            const response = await fetch('http://localhost/movie_ratings/save_comment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${encodeURIComponent(username)}&comment=${encodeURIComponent(comment)}`,
            });

            if (!response.ok) {
                throw new Error('Failed to submit comment');
            }

            // Clear input fields
            username = '';
            comment = '';
            successMessage = 'Comment submitted successfully!';

            // Re-fetch the comments
            const newComments = await fetch('http://localhost/movie_ratings/get_comments.php');
            if (!newComments.ok) {
                throw new Error('Failed to fetch updated comments');
            }
            comments = await newComments.json();
        } catch (error: unknown) {
            if (error instanceof Error) {
                errorMessage = error.message;
            } else {
                errorMessage = 'An unknown error occurred';
            }
        }
    };
</script>

<footer class="py-20 sm:py-32 bg-black border-t border-solid border-orange-950 flex flex-col gap-6 sm:gap-8 justify-center items-center">
    <div class="flex flex-col items-center gap-6 sm:gap-8 justify-center rounded-lg text-center text-white">
        <h2 class="text-2xl font-bold">Add Your Comment</h2>

        <!-- Display error message if any -->
        {#if errorMessage}
            <div class="text-red-500">
                <p>{errorMessage}</p>
            </div>
        {/if}

        <!-- Display success message if any -->
        {#if successMessage}
            <div class="text-green-500">
                <p>{successMessage}</p>
            </div>
        {/if}

        <!-- Comment form -->
        <form on:submit|preventDefault={submitComment} class="flex flex-col gap-4">
            <input 
                type="text" 
                bind:value={username} 
                placeholder="Your Name" 
                required 
                class="p-2 rounded bg-gray-700 text-white placeholder-gray-400"
            />
            <textarea 
                bind:value={comment} 
                placeholder="Your Comment" 
                required 
                class="p-2 rounded bg-gray-700 text-white placeholder-gray-400"
            ></textarea>
            <button type="submit" class="bg-orange-600 text-white py-2 px-4 rounded">Submit</button>
        </form>

        <!-- Display comments -->
        <div class="mt-6 w-full max-w-2xl">
            <h3 class="text-xl font-bold text-gray-200 mb-4">Comments</h3>
            {#each comments as { username, comment, timestamp }}
                <div class="bg-gray-800 text-white p-4 rounded mb-4">
                    <p class="font-semibold">{username}</p>
                    <p>{comment}</p>
                    <p class="text-sm text-gray-400">{new Date(timestamp).toLocaleString()}</p>
                </div>
            {/each}
        </div>
    </div>
</footer>
