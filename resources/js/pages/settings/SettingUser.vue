<script setup lang="ts">
import { Head, usePage, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { ref, onMounted, watch, computed } from 'vue';
import axios from 'axios';
import type { BreadcrumbItem, SharedData } from '@/types';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { useToast } from 'vue-toastification';
import Swal from 'sweetalert2';

const users = ref([]);
const currentPage = ref(1);
const perPage = ref(10);
const totalItems = ref(0);
const toast = useToast();

const filters = ref({
    name: '',
    username: '',
    role: '',
    orderBy: 'name',
    orderDirection: 'asc',
});

const loading = ref(false);

let filterTimeout: ReturnType<typeof setTimeout>;

const fetchUsers = async () => {
    loading.value = true;
    try {
        const response = await axios.get(route('setting-user.data'), {
            params: {
                page: currentPage.value,
                per_page: perPage.value,
                orderBy: filters.value.orderBy,
                orderDirection: filters.value.orderDirection,

                name: filters.value.name,
                username: filters.value.username,
                role: filters.value.role,
            },
        });

        users.value = response.data.data;
        totalItems.value = response.data.total;
    } finally {
        loading.value = false;
    }
};

onMounted(fetchUsers);

watch([currentPage, perPage], fetchUsers);

watch(filters, () => {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(() => {
        currentPage.value = 1;
        fetchUsers();
    }, 300);
}, { deep: true });

function sortBy(column: string) {
    if (filters.value.orderBy === column) {
        filters.value.orderDirection = filters.value.orderDirection === 'asc' ? 'desc' : 'asc';
    } else {
        filters.value.orderBy = column;
        filters.value.orderDirection = 'asc';
    }
}

const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value));

const form = useForm();
const destroy = async (id: number | string) => {
    const result = await Swal.fire({
        title: 'Yakin ingin menghapus user ini?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
        form.delete(route('setting-user.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                fetchUsers();
                Swal.fire({
                    title: "Berhasil",
                    text: "User berhasil dihapus!",
                    icon: "success"
                });
            },
            onError: () => {
                Swal.fire({
                    title: "Gagal",
                    text: "Gagal menghapus user.",
                    icon: "error"
                });
            }
        });
    }
};

const breadcrumbs = [
    { label: 'Manajemen', href: '#' },
    { label: 'User', href: '#' },
    { label: 'Daftar Pengguna' }
];

const page = usePage<SharedData>();

</script>

<template>

    <Head title="Setting User" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="overflow-x-auto p-4">
            <div class="overflow-x-auto rounded-lg shadow ring-1 ring-gray-200">
                <div class="flex justify-end p-3">
                    <a :href="route('setting-user.tambah')"
                        class="text-green-600 hover:text-green-800 hover:underline flex items-center gap-1 text-sm font-medium">
                        <CirclePlus class="w-5 h-5" />
                        Tambah
                    </a>
                </div>
                <table class="min-w-full table-auto bg-white divide-y divide-gray-200 rounded shadow-sm">
                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left w-16">No</th>

                            <th class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 transition"
                                @click="sortBy('name')">
                                <div class="flex items-center gap-1">
                                    <span>Name</span>
                                    <span v-if="filters.orderBy === 'name'">
                                        <span v-if="filters.orderDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </div>
                            </th>

                            <th class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 transition"
                                @click="sortBy('username')">
                                <div class="flex items-center gap-1">
                                    <span>User Name</span>
                                    <span v-if="filters.orderBy === 'username'">
                                        <span v-if="filters.orderDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </div>
                            </th>

                            <th class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 transition"
                                @click="sortBy('role')">
                                <div class="flex items-center gap-1">
                                    <span>Role</span>
                                    <span v-if="filters.orderBy === 'role'">
                                        <span v-if="filters.orderDirection === 'asc'">▲</span>
                                        <span v-else>▼</span>
                                    </span>
                                </div>
                            </th>

                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>

                        <tr class="bg-white border-t">
                            <td class="px-4 py-2"></td>
                            <td class="px-4 py-2">
                                <input type="text" id="name" placeholder="Search name" v-model="filters.name"
                                    class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" id="username" placeholder="Search username"
                                    v-model="filters.username"
                                    class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" id="role" placeholder="Search role" v-model="filters.role"
                                    class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </td>
                            <td class="px-4 py-2"></td>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-sm text-gray-800">
                        <tr v-if="loading">
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Loading...</td>
                        </tr>

                        <tr v-else-if="users.length === 0">
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No users found.</td>
                        </tr>

                        <tr v-for="(user, index) in users" :key="user.id" class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                {{ (currentPage - 1) * perPage + index + 1 }}
                            </td>
                            <td class="px-4 py-3">{{ user.name }}</td>
                            <td class="px-4 py-3">{{ user.username }}</td>
                            <td class="px-4 py-3">{{ user.role }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <a :href="route('setting-user.edit', user.user_id)"
                                    class="text-yellow-600 hover:underline text-sm">
                                    <Pencil />
                                </a>

                                <a href="#" @click="destroy(user.user_id)" class="text-red-600 hover:underline text-sm">
                                    <Trash />
                                </a>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="5" class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-700">
                                    <div>
                                        Page {{ currentPage }} of {{ totalPages }} ({{ totalItems }} total records)
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        <button
                                            class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100 disabled:opacity-50"
                                            :disabled="currentPage === 1" @click="currentPage--">
                                            Prev
                                        </button>

                                        <select v-model="perPage"
                                            class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-200 focus:border-blue-500">
                                            <option :value="5">5</option>
                                            <option :value="10">10</option>
                                            <option :value="25">25</option>
                                            <option :value="50">50</option>
                                        </select>

                                        <button
                                            class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100 disabled:opacity-50"
                                            :disabled="currentPage >= totalPages" @click="currentPage++">
                                            Next
                                        </button>

                                        <span>Jump to:</span>
                                        <input type="number" v-model.number="currentPage" min="1" :max="totalPages"
                                            class="w-20 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-200" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </AppLayout>
</template>
