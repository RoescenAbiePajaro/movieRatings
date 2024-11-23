<script>
    export let y;
</script>

<header
    class={"sticky z-[10] top-0 duration-200 px-6 flex items-center justify-between border-b border-solid " +
        (y > 0 ? " py-4 bg-black border-black" : " py-6 bg-transparent border-transparent")}
>
    <!-- Logo TV -->
    <div class="flex items-center">
        <img 
            src="assets/images/tvapp.png" 
            alt="TV Logo" 
            class="h-8 w-8 mr-3"
        />
        <h1 class="font-medium">
            <b class="font-bold poppins">Svelte</b> <span class="font-bold poppins">Movie Ratings</span>
        </h1>
    </div>
</header>
