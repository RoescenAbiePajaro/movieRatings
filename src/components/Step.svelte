<script>
    export let step; // Expecting an object with { name, icon, image, href }
</script>

<a
    href={step.href}
    target="_blank"
    rel="noopener noreferrer"
    class="flex flex-col gap-4 p-4 sm:p-6 md:p-8 rounded-lg border border-orange-700 text-center group hover:border-orange-400 transition duration-300"
>
    <!-- Icon Section -->
    <div
        class="bg-orange-950 text-orange-400 grid place-items-center p-6 text-5xl md:text-6xl rounded-full mx-auto group-hover:text-orange-200 group-hover:bg-orange-800 transition duration-300"
    >
        <i class={step.icon} />
    </div>

    <!-- Title Section -->
    <h3 class="font-semibold text-xl sm:text-2xl md:text-3xl text-white group-hover:text-red-400 transition duration-300">
        {step.name}
    </h3>

    <!-- Image Section -->
    <div class="relative w-full h-48 sm:h-56 md:h-64 overflow-hidden rounded-lg">
        <img
            src={step.image}
            alt={step.name}
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
        />
    </div>

    <!-- Slot Section -->
    <slot />

    <!-- Optional Footer Section -->
    <div class="mt-auto flex justify-center">
        <div
            class="relative text-red-900 hover:text-white transition duration-300 cursor-pointer"
        >
            View Details
        </div>
    </div>
</a>

<style>
    /* Define general styling for consistency */
    a {
        text-decoration: none;
    }

    h3 {
        word-break: break-word;
    }

    /* Add custom hover animations */
    img {
        transition: transform 0.3s ease-in-out;
    }

    i {
        transition: color 0.3s ease-in-out;
    }
</style>
