<div class="relative overflow-hidden {{ $class }}" x-data="app">
    <div x-init="startSlideshow()" @mouseenter="stopSlideshow()" @mouseleave="startSlideshow()">
        <div class="w-full h-full flex transition-transform ease-in-out duration-1000 transform" x-bind:style="'transform: translateX(-' + currentIndex * 100 + '%)'">
            <template x-for="(image, index) in images" :key="index">
                <img :src="getStorageUrl(image)" alt="Banner Image" class="min-w-full h-full object-cover object-center cursor-pointer" @click="goToMovie(index)" />
            </template>
        </div>
        <button
            class="absolute top-0 left-0 h-full w-28 md:w-40 flex items-center justify-start bg-gradient-to-r from-gray-950/80 to-transparent opacity-0 hover:opacity-100 duration-300"
            @click="prevImage()"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a0a0a0" class="ml-4 md:ml-8 w-8 md:w-10 h-8 md:h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>
        <button
            class="absolute top-0 right-0 h-full w-28 md:w-40 flex items-center justify-end bg-gradient-to-l from-gray-950/80 to-transparent opacity-0 hover:opacity-100 duration-300"
            @click="nextImage()"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a0a0a0" class="mr-4 md:mr-8 w-8 md:w-10 h-8 md:h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
        <div class="absolute left-1/2 bottom-4 transform -translate-x-1/2 flex items-center gap-2 sm:gap-4">
            <template x-for="(image, index) in images" :key="index">
                <button
                    class="w-2 sm:w-3 aspect-square rounded-full shadow-sm"
                    :class="{ 'bg-bg-100': currentIndex === index, 'bg-bg-300': currentIndex !== index }"
                    @click="goToImage(index)"
                    ></button>
            </template>
        </div>
    </div>
    <script>
        const app = {
            images: {!! json_encode($baners) !!},
            links: {!! json_encode($links) !!},
            currentIndex: 0,
            interval: null,
            getStorageUrl(image) {
                return "{{ url('storage') }}/" + image;
            },
            goToMovie(index) {
                window.location.href = "/movies/" + this.links[index];
            },
            startSlideshow() {
                this.interval = setInterval(() => {
                    this.nextImage();
                }, 10000);
            },
            stopSlideshow() {
                clearInterval(this.interval);
            },
            nextImage() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            },
            prevImage() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            },
            goToImage(index) {
                this.currentIndex = index;
            }
        };
    </script>
</div>
