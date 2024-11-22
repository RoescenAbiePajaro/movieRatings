<!-- +layout.svelte -->
<script>
	// @ts-nocheck
	  import { Router } from 'svelte-routing';
	  import Footer from "../components/Footer.svelte";
	  import Header from "../components/Header.svelte";
	  import "../app.css";
	  /**
	   * @type {number}
	   */
	  let y;
	  let innerWidth = 0;
	  let innerHeight = 0;
	
	  function goTop() {
		document.body.scrollIntoView();
	  }
	</script>
	
	<Router>
	  <div class="container relative flex flex-col max-w-[1400px] mx-auto w-full text-sm sm:text-base min-h-screen">
		<!-- Scroll to top button -->
		<div class="fixed bottom-0 w-full duration-200 flex p-10 z-[10] {y > 0 ? 'opacity-full pointer-events-auto' : 'pointer-events-none opacity-0'}">
		  <button 
			on:click="{goTop}" 
			class="ml-auto rounded-full bg-slate-900 text-violet-400 px-3 sm:px-4 hover:bg-slate-800 cursor-pointer aspect-square grid place-items-center"
			aria-label="Scroll to top"
		  >
			<i class="fa-solid fa-arrow-up"></i>
			<span class="sr-only">Scroll to top</span>  <!-- Hides text visually, but keeps it for screen readers -->
		  </button>
		</div>
	
		<Header {y} {innerHeight}></Header>
		<slot></slot>
		<Footer></Footer>
	  </div>
	</Router>
	
	<svelte:window bind:scrollY="{y}" bind:innerHeight bind:innerWidth></svelte:window>
	