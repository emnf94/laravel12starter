<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { type SharedData, type User } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { ChevronsUpDown } from 'lucide-vue-next';
import AdminMenuContent from './AdminMenuContent.vue';



const page = usePage<SharedData>();
const user = page.props.auth.user as User;
const { isMobile, state } = useSidebar();
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                        <Avatar class="h-8 w-8 overflow-hidden rounded-lg">

                        </Avatar>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-medium">Management</span>
                            
                        </div>
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'" align="end"
                    :side-offset="4">
                    <AdminMenuContent />
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
