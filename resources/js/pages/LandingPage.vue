<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{ appName: string }>();

// Mobile menu open state
const mobileMenuOpen = ref(false);

function toggleMenu() {
    mobileMenuOpen.value = !mobileMenuOpen.value;
}
</script>

<template>

    <Head :title="appName" />

    <div class="min-h-screen bg-gradient-to-r from-[#2ecc71] to-[#c0392b] text-white flex flex-col">
        <!-- Navbar -->
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Nama Aplikasi -->
            <div class="text-2xl font-bold select-none cursor-pointer">{{ appName }}</div>

            <!-- Grup Link Utama -->
            <div class="hidden md:flex space-x-6 pl-8">
                <a href="#fitur" class="text-white hover:text-[#c0392b] transition font-medium">Fitur</a>
                <a href="#faq" class="text-white hover:text-[#c0392b] transition font-medium">FAQs</a>
                <a href="#kontak" class="text-white hover:text-[#c0392b] transition font-medium">Kontak</a>
            </div>

            <!-- Spacer besar untuk pisah grup link -->
            <div class="flex-grow"></div>

            <!-- Grup Link Auth -->
            <div class="hidden md:flex space-x-4 items-center">
                <template v-if="$page.props.auth?.user">
                    <Link :href="route('dashboard')" class="text-white hover:text-[#c0392b] transition font-medium">
                    Dashboard</Link>
                </template>
                <template v-else>
                    <Link :href="route('login')" class="text-white hover:text-[#c0392b] transition font-medium">Masuk
                    </Link>
                    <Link :href="route('register')"
                        class="text-[#c0392b] bg-white px-3 py-1 rounded-md font-medium hover:bg-yellow-200 transition">
                    Daftar</Link>
                </template>
            </div>

            <!-- Hamburger button (mobile) -->
            <button @click="toggleMenu" class="md:hidden text-white focus:outline-none ml-4" aria-label="Toggle menu">
                <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Mobile menu -->
            <div :class="[
                'flex flex-col md:hidden bg-[#2ecc71] rounded-b-lg p-4 absolute top-full left-0 w-full z-20',
                mobileMenuOpen ? 'block' : 'hidden'
            ]">
                <a href="#fitur" class="py-2 text-white font-medium" @click="mobileMenuOpen = false">Fitur</a>
                <a href="#faq" class="py-2 text-white font-medium" @click="mobileMenuOpen = false">FAQs</a>
                <a href="#kontak" class="py-2 text-white font-medium" @click="mobileMenuOpen = false">Kontak</a>
                <template v-if="$page.props.auth?.user">
                    <Link :href="route('dashboard')" class="py-2 text-white font-medium"
                        @click="mobileMenuOpen = false">Dashboard</Link>
                </template>
                <template v-else>
                    <Link :href="route('login')" class="py-2 text-white font-medium" @click="mobileMenuOpen = false">
                    Masuk</Link>
                    <Link :href="route('register')" class="py-2 text-[#c0392b] bg-white rounded-md px-3 font-medium"
                        @click="mobileMenuOpen = false">Daftar</Link>
                </template>
            </div>
        </nav>


        <!-- Hero Section -->
        <section class="flex-grow px-6 md:px-0 my-16">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 items-center">
                <div class="text-center md:text-left md:pl-16">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight mb-6">
                        Bangun aplikasi web modern dan cepat dengan Vue 3 & Inertia.js
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl opacity-90 mb-8 leading-relaxed">
                        Ciptakan aplikasi single-page yang mulus dengan backend Laravel yang kuat.
                    </p>
                    <a href="/register"
                        class="inline-block bg-yellow-400 text-[#c0392b] font-semibold px-6 sm:px-8 py-3 rounded-lg shadow-lg hover:bg-yellow-300 transition">
                        🚀 Mulai Sekarang
                    </a>
                </div>
                <div class="flex justify-center">
                    <img src="https://static.wikia.nocookie.net/kamenrider/images/9/9d/Shin_Rider_1_Kick.jpeg/revision/latest/scale-to-width-down/1000?cb=20230426055726"
                        alt="Hero Image"
                        class="rounded-xl shadow-xl max-w-full h-auto transform hover:scale-105 transition duration-300" />
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="bg-white text-gray-800 py-20 my-16 rounded-t-3xl shadow-inner">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
                    Mengapa Memilih {{ appName }}?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                    <div
                        class="flex flex-col items-center text-center p-6 border rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="bg-[#2ecc71] text-white rounded-full p-4 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 19a7 7 0 100-14 7 7 0 000 14z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-xl mb-2">Cepat & Efisien</h3>
                        <p class="text-gray-600">
                            Waktu muat halaman cepat dan interaksi client-server yang lancar.
                        </p>
                    </div>

                    <div
                        class="flex flex-col items-center text-center p-6 border rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="bg-[#2ecc71] text-white rounded-full p-4 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h4a2 2 0 012 2v14a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-xl mb-2">Mudah Digunakan</h3>
                        <p class="text-gray-600">
                            API sederhana dan dokumentasi lengkap untuk pengembangan yang mudah.
                        </p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-6 border rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="bg-[#2ecc71] text-white rounded-full p-4 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m-4-4v8" />
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-xl mb-2">Komunitas Besar</h3>
                        <p class="text-gray-600">
                            Banyak tutorial, paket, dan bantuan dari komunitas Vue dan Laravel.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQs Section -->
        <section id="faq" class="container mx-auto px-6 py-20 my-16 max-w-4xl">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Pertanyaan Umum</h2>

            <div class="space-y-6">
                <details class="border border-gray-300 rounded-md p-4">
                    <summary class="font-semibold cursor-pointer">
                        Apakah Vue 3 & Inertia.js bisa digunakan untuk aplikasi besar?
                    </summary>
                    <p class="mt-2 text-gray-700">
                        Tentu saja, banyak aplikasi besar menggunakan kombinasi ini untuk pengalaman pengguna yang mulus
                        dan backend yang kuat.
                    </p>
                </details>

                <details class="border border-gray-300 rounded-md p-4">
                    <summary class="font-semibold cursor-pointer">
                        Bagaimana cara mulai belajar Vue 3 & Inertia.js?
                    </summary>
                    <p class="mt-2 text-gray-700">
                        Mulailah dengan dokumentasi resmi Vue 3 dan Inertia.js, lalu coba buat aplikasi sederhana.
                    </p>
                </details>

                <details class="border border-gray-300 rounded-md p-4">
                    <summary class="font-semibold cursor-pointer">
                        Apakah Laravel wajib untuk menggunakan Inertia.js?
                    </summary>
                    <p class="mt-2 text-gray-700">
                        Laravel adalah salah satu backend yang paling umum digunakan, tapi Inertia.js juga bisa
                        digunakan dengan backend lain seperti Rails atau Django.
                    </p>
                </details>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="kontak" class="bg-white py-20 my-16 rounded-b-3xl shadow-inner text-black">
            <div class="container mx-auto px-6 max-w-3xl">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Hubungi Kami</h2>
                <form class="space-y-6" @submit.prevent="alert('Form submitted!')">
                    <input type="text" placeholder="Nama Anda"
                        class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-[#2ecc71]"
                        required />
                    <input type="email" placeholder="Email Anda"
                        class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-[#2ecc71]"
                        required />
                    <textarea placeholder="Pesan" rows="5"
                        class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-[#2ecc71]"
                        required></textarea>
                    <button type="submit"
                        class="bg-[#2ecc71] hover:bg-[#27ae60] text-white font-semibold px-6 py-3 rounded-md transition w-full">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </section>

        <footer class=" py-6 text-center text-white">
            &copy; 2025 {{ appName }}. All rights reserved.
        </footer>
    </div>
</template>