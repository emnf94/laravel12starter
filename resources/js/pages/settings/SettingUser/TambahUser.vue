<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';

interface RoleOption {
    label: string;
    value: string;
}

interface Props {
    user: {
        name: string;
        email: string;
        role: string;
        encrypted_id: string;
    };
    roles: RoleOption[];
}

const props = defineProps<Props>();

const breadcrumbs = [
    { label: 'Manajemen', href: '#' },
    { label: 'User', href: '#' },
    { label: 'Edit', href: '#' },
];

const form = useForm({
    name: '',
    email: '',
    id: '',
    role: '',
    phone: '',
    password: ''

});

const submit = () => {
    form.post(route('setting-user.save'), {
        preserveScroll: true,
        onError: (errors) => {
            console.log('Validation Errors:', errors);
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Tambah User" />

        <div class="p-4">
            <div class="rounded-lg shadow ring-1 ring-gray-200 bg-white p-6">
                <HeadingSmall title="Tambah User" description="Tambah data pengguna di bawah ini." />

                <form @submit.prevent="submit" class="space-y-6 mt-6">
                    <div class="grid gap-2">
                        <Label for="name">Nama</Label>
                        <Input id="name" v-model="form.name" placeholder="Nama lengkap" autocomplete="name" required />
                        <InputError :message="form.errors.name ? form.errors.name[0] : ''" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" v-model="form.email" placeholder="Alamat email"
                            autocomplete="email" required />
                        <InputError :message="form.errors.email" class="mt-1" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="phone">Nomor Whatsapp</Label>
                        <Input id="phone" type="phone" v-model="form.phone" placeholder="Nomor Whatsapp"
                            autocomplete="phone" required />
                        <InputError :message="form.errors.phone" class="mt-1" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="role">Role</Label>
                        <select id="role" v-model="form.role"
                            class="mt-1 block w-full rounded border-gray-300 focus:ring focus:ring-blue-200" required>
                            <option value="">Pilih peran</option>
                            <option v-for="role in props.roles" :key="role.value">
                                {{ role.label }}
                            </option>
                        </select>
                        <InputError :message="form.errors.role" class="mt-1" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password">Password Baru</Label>
                        <Input id="password" type="password" v-model="form.password" placeholder="Masukan Password Baru"
                            autocomplete="new-password" />
                        <InputError :message="form.errors.password" class="mt-1" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Simpan</Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
