<script setup>
import { ref, computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const currentPath = computed(() => page.url);

const logoutForm = useForm({});
const logout = () => logoutForm.post('/logout');

const sidebarCollapsed = ref(false);
const toggleSidebar = () => sidebarCollapsed.value = !sidebarCollapsed.value;

const menuSections = [
    {
        title: 'Content',
        items: [
            { label: 'Dashboard', href: '/admin', icon: 'bi-speedometer2', exact: true },
            { label: 'Homepage', href: '/admin/homepage', icon: 'bi-house' },
            { label: 'Pages', href: '/admin/pages', icon: 'bi-file-text' },
            { label: 'Rooms', href: '/admin/rooms', icon: 'bi-door-open' },
            { label: 'News', href: '/admin/news', icon: 'bi-newspaper' },
            { label: 'Gallery', href: '/admin/gallery', icon: 'bi-images' },
            { label: 'Testimonials', href: '/admin/testimonials', icon: 'bi-chat-quote' },
            { label: 'Restaurant Menu', href: '/admin/menu', icon: 'bi-cup-hot' },
        ]
    },
    {
        title: 'Bookings',
        items: [
            { label: 'Room Bookings', href: '/admin/bookings', icon: 'bi-calendar-check' },
            { label: 'Spa Bookings', href: '/admin/spa/bookings', icon: 'bi-flower1' },
            { label: 'Tennis Bookings', href: '/admin/tennis-court-bookings', icon: 'bi-dribbble' },
        ]
    },
    {
        title: 'Services',
        items: [
            { label: 'Spa Services', href: '/admin/spa/services', icon: 'bi-flower2' },
            { label: 'Tennis Courts', href: '/admin/tennis/courts', icon: 'bi-trophy' },
        ]
    },
    {
        title: 'Management',
        items: [
            { label: 'Contacts', href: '/admin/contacts', icon: 'bi-envelope' },
            { label: 'Congress Inquiries', href: '/admin/congress-contacts', icon: 'bi-building' },
            { label: 'Celebration Inquiries', href: '/admin/celebration-contacts', icon: 'bi-balloon-heart' },
            { label: 'Newsletter', href: '/admin/newsletter', icon: 'bi-send' },
        ]
    },
    {
        title: 'System',
        items: [
            { label: 'Settings', href: '/admin/settings', icon: 'bi-gear' },
            { label: 'Translations', href: '/admin/translations', icon: 'bi-translate' },
            { label: 'Email Templates', href: '/admin/email-templates', icon: 'bi-envelope-paper' },
            { label: 'Users', href: '/admin/users', icon: 'bi-people' },
        ]
    }
];

const isActive = (item) => {
    if (item.exact) {
        return currentPath.value === item.href;
    }
    return currentPath.value.startsWith(item.href);
};
</script>

<template>
    <div
        class="admin-panel min-h-screen"
        :style="{
            background: '#f1f5f9',
            fontFamily: 'Inter, Segoe UI, system-ui, -apple-system, sans-serif',
            paddingLeft: sidebarCollapsed ? '70px' : '260px'
        }"
    >

        <!-- Sidebar -->
        <aside
            :class="[
                'flex flex-col transition-all duration-300 fixed top-0 left-0 h-full z-40'
            ]"
            :style="{ background: '#0f172a', width: sidebarCollapsed ? '70px' : '260px' }"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between px-4 flex-shrink-0" style="height: 64px; border-bottom: 1px solid rgba(255,255,255,0.07);">
                <Link href="/admin" class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="bi bi-building text-white text-sm"></i>
                    </div>
                    <div v-if="!sidebarCollapsed" class="min-w-0">
                        <div class="text-white font-bold text-sm leading-tight truncate">Alexandar Palace</div>
                        <div class="text-xs truncate" style="color: #f59e0b;">Admin Portal</div>
                    </div>
                </Link>
                <button @click="toggleSidebar" class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center transition-colors" style="color: #64748b;" onmouseover="this.style.background='rgba(255,255,255,0.07)';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#64748b'">
                    <i :class="sidebarCollapsed ? 'bi bi-chevron-right' : 'bi bi-chevron-left'" class="text-xs"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-3" style="scrollbar-width: thin; scrollbar-color: #1e293b transparent;">
                <div v-for="section in menuSections" :key="section.title" class="mb-1">
                    <div v-if="!sidebarCollapsed" class="px-4 pt-3 pb-1 text-xs font-semibold uppercase tracking-widest" style="color: #334155; letter-spacing: 0.1em;">
                        {{ section.title }}
                    </div>
                    <div v-else class="px-2 pt-3 pb-1">
                        <div class="h-px" style="background: rgba(255,255,255,0.06);"></div>
                    </div>
                    <ul class="space-y-0.5 px-2">
                        <li v-for="item in section.items" :key="item.href">
                            <Link
                                :href="item.href"
                                :title="sidebarCollapsed ? item.label : ''"
                                :class="['flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-150 group relative', sidebarCollapsed ? 'justify-center' : '']"
                                :style="isActive(item)
                                    ? 'background: rgba(245,158,11,0.15); color: #fbbf24;'
                                    : 'color: #94a3b8;'"
                                onmouseover="if(!this.dataset.active) { this.style.background='rgba(255,255,255,0.05)'; this.style.color='#e2e8f0'; }"
                                onmouseout="if(!this.dataset.active) { this.style.background=''; this.style.color='#94a3b8'; }"
                            >
                                <!-- Active indicator bar -->
                                <div v-if="isActive(item)" class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 rounded-r" style="background: #f59e0b;"></div>
                                <i :class="['bi', item.icon, 'text-base flex-shrink-0']"></i>
                                <span v-if="!sidebarCollapsed" class="text-sm font-medium">{{ item.label }}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- User / Footer -->
            <div class="flex-shrink-0 p-3" style="border-top: 1px solid rgba(255,255,255,0.07);">
                <div v-if="!sidebarCollapsed" class="flex items-center gap-3 px-2 py-2 mb-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-white text-sm font-bold" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        {{ ($page.props.auth?.user?.name || 'A')[0].toUpperCase() }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-white truncate">{{ $page.props.auth?.user?.name || 'Admin' }}</div>
                        <div class="text-xs truncate" style="color: #475569;">{{ $page.props.auth?.user?.email }}</div>
                    </div>
                </div>
                <div :class="['flex gap-1', sidebarCollapsed ? 'flex-col items-center' : '']">
                    <Link href="/" target="_blank" class="flex items-center justify-center gap-2 px-2 py-2 rounded-lg text-xs transition-colors" :class="sidebarCollapsed ? 'w-10 h-10' : 'flex-1'" style="color: #64748b;" onmouseover="this.style.background='rgba(255,255,255,0.07)';this.style.color='#e2e8f0'" onmouseout="this.style.background='';this.style.color='#64748b'" :title="sidebarCollapsed ? 'View Site' : ''">
                        <i class="bi bi-box-arrow-up-right text-sm"></i>
                        <span v-if="!sidebarCollapsed">View Site</span>
                    </Link>
                    <button @click="logout" class="flex items-center justify-center gap-2 px-2 py-2 rounded-lg text-xs transition-colors" :class="sidebarCollapsed ? 'w-10 h-10' : 'flex-1'" style="color: #64748b;" onmouseover="this.style.background='rgba(239,68,68,0.1)';this.style.color='#f87171'" onmouseout="this.style.background='';this.style.color='#64748b'" :title="sidebarCollapsed ? 'Sign Out' : ''">
                        <i class="bi bi-box-arrow-right text-sm"></i>
                        <span v-if="!sidebarCollapsed">Sign Out</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="min-h-screen flex flex-col">
            <!-- Top Bar — fixed at top -->
            <header class="flex items-center justify-between px-6 bg-white z-30" style="height: 64px; border-bottom: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 text-sm" style="color: #cbd5e1;">
                        <i class="bi bi-grid-3x3-gap"></i>
                        <span>/</span>
                    </div>
                    <h1 class="text-lg font-semibold text-slate-800">
                        <slot name="title">Dashboard</slot>
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <slot name="actions"></slot>
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs border" style="color: #94a3b8; border-color: #e2e8f0; background: #f8fafc;">
                        <i class="bi bi-clock-history"></i>
                        <span>{{ new Date().toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short' }) }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Content - scrollable area -->
            <main class="flex-1 overflow-auto" style="padding: 24px;">
                <div v-if="$page.props.flash?.success" class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #dcfce7;">
                        <i class="bi bi-check text-xs"></i>
                    </div>
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash?.error" class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fee2e2;">
                        <i class="bi bi-exclamation text-xs"></i>
                    </div>
                    {{ $page.props.flash.error }}
                </div>

                <slot />
            </main>
        </div>
    </div>
</template>

<style>
/* Reset Paradise template styles for admin panel */
.admin-panel,
.admin-panel *,
.admin-panel *::before,
.admin-panel *::after {
    box-sizing: border-box;
}
.admin-panel {
    position: relative !important;
    margin: 0 !important;
    padding-top: 0 !important;
    line-height: 1.5;
}
.admin-panel * {
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
}
.admin-panel main {
    margin-top: 0 !important;
}
.admin-panel header {
    position: relative !important;
    margin-top: 0 !important;
    flex-shrink: 0 !important;
}
/* Override any Paradise template negative margins */
.admin-panel .flex,
.admin-panel .grid,
.admin-panel div {
    margin-top: revert;
}
.admin-panel h1, .admin-panel h2, .admin-panel h3, .admin-panel h4, .admin-panel h5, .admin-panel h6 {
    margin: 0;
    font-weight: 600;
}
.admin-panel p {
    margin: 0;
}
.admin-panel nav::-webkit-scrollbar {
    width: 4px;
}
.admin-panel nav::-webkit-scrollbar-track {
    background: transparent;
}
.admin-panel nav::-webkit-scrollbar-thumb {
    background: #1e293b;
    border-radius: 4px;
}
</style>
