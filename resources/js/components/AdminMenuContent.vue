<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { UserCheck, Ellipsis } from 'lucide-vue-next';

const handleLogout = () => {
    router.flushAll();
};

</script>

<template>
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="flex items-center px-2 py-1 text-sm" :href="route('setting-user')" prefetch>
            <UserCheck class="mr-2 h-5 w-5" />
            User
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="flex items-center px-2 py-1 text-sm" prefetch>
            <Ellipsis class="mr-2 h-5 w-5" />
            Etc
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
</template>
