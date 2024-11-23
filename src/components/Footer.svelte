<script lang="ts">
    import { onMount } from 'svelte';

    interface Comment {
        id: number;
        username: string;
        comment: string;
        timestamp: string;
        reply_id: number;
    }

    let comments: Comment[] = [];
    let username = '';
    let comment = '';
    let replyId = 0;
    let errorMessage = '';
    let successMessage = '';
    let isLoading = false;

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
            const newComment: Comment = {
                id: comments.length + 1,
                username,
                comment,
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

<footer class="py-20 sm:py-32 bg-black border-t border-solid border-orange-950 flex flex-col gap-6 sm:gap-8 justify-center items-center">
    <div class="flex flex-col items-center gap-6 sm:gap-8 text-center text-white">
        <h2 class="text-2xl font-bold">Add Your Comment</h2>

        {#if errorMessage}
            <div class="text-red-500">{errorMessage}</div>
        {/if}

        {#if successMessage}
            <div class="text-green-500">{successMessage}</div>
        {/if}

        <form on:submit|preventDefault={submitComment} class="flex flex-col gap-4 w-full max-w-md">
            <input type="text" bind:value={username} placeholder="Your Name" required class="p-2 rounded bg-gray-700 text-white placeholder-gray-400" />
            <textarea bind:value={comment} placeholder="Your Comment" required class="p-2 rounded bg-gray-700 text-white placeholder-gray-400"></textarea>
            <button type="submit" class="bg-orange-600 text-white py-2 px-4 rounded">
                {#if isLoading} Submitting... {:else} Submit {/if}
            </button>
        </form>

        <div class="mt-6 w-full max-w-2xl">
            <h3 class="text-xl font-bold text-gray-200 mb-4">Comments</h3>
            {#each comments as { id, username, comment, timestamp }}
                <div class="bg-gray-800 text-white p-4 rounded mb-4">
                    <p class="font-semibold">{username}</p>
                    <p>{comment}</p>
                    <p class="text-sm text-gray-400">{new Date(timestamp).toLocaleString()}</p>
                    <button class="text-orange-500 text-sm mt-2" on:click={() => replyToComment(id, username)}>
                        Reply
                    </button>
                </div>
            {/each}
        </div>
    </div>
</footer>
