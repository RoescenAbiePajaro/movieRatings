<!-- header.svelte -->
<script>
    export let y;
</script>

<header
    class={"sticky z-[10] top-0 duration-200 px-6 flex items-center justify-between border-b border-solid " +
        (y > 0 ? " py-4 bg-red-800 border-red-950" : " py-6 bg-transparent border-transparent")}
>
    <h1 class="font-medium">
        <b class="font-bold poppins">Svelte</b> <span class="font-bold poppins">Movie Ratings</span>
    </h1>
</header>
