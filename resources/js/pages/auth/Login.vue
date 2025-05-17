<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Masuk ke akun Anda" description="Masukkan email dan kata sandi Anda di bawah ini untuk masuk">

        <Head title="Login" />

        <div v-if="status" class="mb-4 rounded-md bg-green-100 p-3 text-center text-sm font-medium text-green-700">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-4">
                <!-- Email -->
                <div class="grid gap-1">
                    <Label for="email">Alamat Email</Label>
                    <Input id="email" type="email" required autofocus :tabindex="1" autocomplete="email"
                        v-model="form.email" placeholder="email@contoh.com" class="rounded-lg" />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div class="grid gap-1">
                    <div class="flex items-center justify-between">
                        <Label for="password">Kata Sandi</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')"
                            class="text-sm text-blue-600 hover:underline" :tabindex="5">
                            Lupa kata sandi?
                        </TextLink>
                    </div>
                    <Input id="password" type="password" required :tabindex="2" autocomplete="current-password"
                        v-model="form.password" placeholder="Kata Sandi" class="rounded-lg" />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Remember me -->
                <div class="flex items-center space-x-3">
                    <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                    <Label for="remember">Ingat saya</Label>
                </div>

                <!-- Submit button -->
                <Button type="submit"
                    class="mt-4 w-full rounded-lg bg-blue-600 text-white transition hover:bg-blue-700 disabled:opacity-70"
                    :tabindex="4" :disabled="form.processing">
                    <span class="flex items-center justify-center gap-2">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        <span>Masuk</span>
                    </span>
                </Button>
            </div>

            <!-- Register link -->
            <div class="text-center text-sm text-muted-foreground mt-4">
                Belum punya akun?
                <TextLink :href="route('register')" :tabindex="5" class="text-blue-600 hover:underline">
                    Daftar
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
