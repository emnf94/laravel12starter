<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbs = [
    { label: 'Pengaturan', href: '#' },
    { label: 'Tampilan', href: '#' }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Pengaturan tampilan" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Pengaturan tampilan" description="Perbarui pengaturan tampilan akun Anda." />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
