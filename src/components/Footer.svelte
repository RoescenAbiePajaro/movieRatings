<script lang="ts">
    import { onMount } from 'svelte';
    import { Filter } from 'bad-words'; // Import the bad-words library

    interface Comment {
        id: number;
        username: string;
        comment: string;
        timestamp: string;
        reply_id: number;
    }

    // Initialize the bad-words filter
    const filter = new Filter();

    let comments: Comment[] = [];
    let username = '';
    let comment = '';
    let replyId = 0;
    let errorMessage = '';
    let successMessage = '';
    let isLoading = false;
    let showRecentComments = false; // State to track if we should show recent comments

    // Function to check if a comment contains any bad words
    const containsBadWords = (text: string) => {
        return filter.isProfane(text); // Returns true if the text contains bad words
    };

    // Function to toggle recent comments
    const toggleRecentComments = () => {
        showRecentComments = !showRecentComments;
    };

    // Function to get filtered comments
    const filteredComments = () => {
        if (showRecentComments) {
            // Assuming "new" means comments from the last 24 hours
            const oneDayAgo = new Date(Date.now() - 24 * 60 * 60 * 1000);
            return comments.filter(comment => new Date(comment.timestamp) > oneDayAgo);
        }
        return comments;
    };

    // Fetch comments on component mount
    onMount(async () => {
        try {
            const response = await fetch('http://localhost:8080/api/get.php');

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (!Array.isArray(data)) {
                throw new Error('Received non-JSON response or unexpected data format');
            }

            comments = data.map((comment: any) => ({
                id: comment.id,
                username: comment.username,
                comment: comment.comment,
                timestamp: comment.timestamp,
                reply_id: comment.reply_id
            }));
        } catch (error) {
            console.error('Failed to fetch comments:', error);
            errorMessage = 'Failed to fetch comments';
        }
    });

    const submitComment = async () => {
        isLoading = true;
        try {
            // Check for profanity in the comment using the bad-words library
            if (containsBadWords(comment)) {
                errorMessage = 'Your comment contains inappropriate language. Please modify it.';
                isLoading = false;
                return; // Stop further execution if bad words are found
            }

            const newComment: Comment = {
                id: comments.length + 1,
                username: username || 'Anonymous',  // Use 'Anonymous' if username is empty
                comment: comment,
                timestamp: new Date().toISOString(),
                reply_id: replyId
            };

            const formData = new FormData();
            formData.append('username', newComment.username);
            formData.append('comment', newComment.comment);
            formData.append('reply_id', String(newComment.reply_id));

            const response = await fetch('http://localhost:8080/api/post.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            successMessage = result.message;

            const response2 = await fetch('http://localhost:8080/api/get.php');
            const data = await response2.json();

            if (!Array.isArray(data)) {
                throw new Error('Received non-JSON response or unexpected data format');
            }

            comments = data.map((comment: any) => ({
                id: comment.id,
                username: comment.username,
                comment: comment.comment,
                timestamp: comment.timestamp,
                reply_id: comment.reply_id
            }));

            username = '';
            comment = '';
            replyId = 0;
        } catch (error) {
            errorMessage = error instanceof Error ? error.message : 'An unknown error occurred';
        } finally {
            isLoading = false;
        }
    };

    const replyToComment = (id: number, name: string) => {
        replyId = id;
        successMessage = '';
        errorMessage = '';
        comment = `Replying to ${name}: `;
    };
</script>

<style>
    footer {
        background-color: #000; /* Black background */
        color: #fff; /* White text */
        border-top: 1px solid #333; /* Subtle dark border */
    }

    form input,
    form textarea {
        background-color: #333; /* Dark background for inputs */
        color: #fff; /* White text */
        border: 1px solid #444; /* Slightly lighter border */
        padding: 8px;
        border-radius: 8px;
    }

    button {
        background-color: #1877f2; /* Facebook blue */
        color: white;
        padding: 10px 16px;
        border-radius: 4px;
        cursor: pointer;
        border: none;
        font-weight: bold;
    }

    button:hover {
        background-color: #145db4;
    }

    .comments {
        background-color: #222; /* Dark comment background */
        padding: 16px;
        border-radius: 8px;
        margin-top: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); /* Darker shadow */
    }

    .comment {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    .comment-avatar {
        width: 40px;
        height: 40px;
        background-color: #555; /* Dark gray avatar */
        border-radius: 50%;
    }

    .comment-body {
        flex-grow: 1;
    }

    .comment-meta {
        font-size: 12px;
        color: #bbb; /* Light gray text for timestamps */
    }

    .reply-btn {
        color: #1877f2; /* Facebook blue for reply button */
        cursor: pointer;
    }

    .reply-btn:hover {
        text-decoration: underline;
    }
</style>

<footer class="py-20 sm:py-32 bg-black border-t border-solid border-gray-800 flex flex-col gap-6 sm:gap-8 justify-center items-center">
    <div class="flex flex-col items-center gap-6 sm:gap-8 text-center text-white w-full">
        <h2 class="text-2xl font-bold">Join the Discussion</h2>

        <!-- Button to toggle recent comments -->
        <button on:click={toggleRecentComments} class="bg-gray-700 text-white p-2 rounded">
            {showRecentComments ? 'Show All Comments' : 'Show Recent Comments'}
        </button>

        {#if errorMessage}
            <div class="text-red-500">{errorMessage}</div>
        {/if}

        {#if successMessage}
            <div class="text-green-500">{successMessage}</div>
        {/if}

        <form on:submit|preventDefault={submitComment} class="flex flex-col gap-4 w-full max-w-md bg-gray-800 p-4 rounded shadow-md">
            <input type="text" bind:value={username} placeholder="Your Name (Optional)" class="p-2 rounded bg-gray-700 text-white placeholder-gray-400 w-full text-left" />
            <textarea bind:value={comment} placeholder="Write a comment..." required class="p-2 rounded bg-gray-700 text-white placeholder-gray-400 w-full h-32 text-left"></textarea>
            <button type="submit">
                {#if isLoading} Submitting... {:else} Post {/if}
            </button>
        </form>

        <div class="mt-6 w-full max-w-3xl">
            <h3 class="text-xl font-semibold text-gray-200 mb-4">Comments</h3>
            {#each filteredComments() as { id, username, comment, timestamp }}
                <div class="bg-gray-800 text-white p-4 rounded shadow-md mb-4">
                    <div class="flex items-start gap-4">
                        <!-- Avatar placeholder -->
                        <div class="w-10 h-10 rounded-full bg-gray-600"></div>
                        <div class="flex-1">
                            <p class="font-semibold">{username}</p>
                            <p class="text-sm">{comment}</p>
                            <p class="text-xs text-gray-400 mt-1">{new Date(timestamp).toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="mt-2 flex gap-4 text-sm text-white">
                        <button class="reply-btn text-white" on:click={() => replyToComment(id, username)}>Reply</button>
                    </div>
                </div>
            {/each}
        </div>
    </div>
</footer>
