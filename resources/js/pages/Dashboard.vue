<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const { props } = usePage();

const isAdmin = props.auth.user.role ?? 'user';

const breadcrumbs = [
    { label: 'Dashboard', href: '/dashboard' }
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <p v-if="isAdmin==='admin'">Admin</p>
            <p v-else>User</p>
        </div>
    </AppLayout>
</template>
