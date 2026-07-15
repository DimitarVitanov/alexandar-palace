<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from './Layout.vue';

const props = defineProps({
    stats: Object,
    recent_bookings: Array,
    recent_contacts: Array,
});

const statCards = [
    {
        label: 'Total Rooms',
        value: props.stats?.rooms || 0,
        icon: 'bi-door-open',
        href: '/admin/rooms',
        accent: '#3b82f6',
        bg: '#eff6ff',
        trend: 'Manage inventory',
    },
    {
        label: 'News Articles',
        value: props.stats?.news || 0,
        icon: 'bi-newspaper',
        href: '/admin/news',
        accent: '#8b5cf6',
        bg: '#f5f3ff',
        trend: 'Published content',
    },
    {
        label: 'Pending Bookings',
        value: props.stats?.pending_bookings || 0,
        icon: 'bi-calendar-check',
        href: '/admin/bookings',
        accent: '#f59e0b',
        bg: '#fffbeb',
        trend: 'Awaiting action',
    },
    {
        label: 'Unread Messages',
        value: props.stats?.unread_contacts || 0,
        icon: 'bi-envelope',
        href: '/admin/contacts',
        accent: '#ef4444',
        bg: '#fef2f2',
        trend: 'New inquiries',
    },
];

const quickActions = [
    { label: 'Add Room', icon: 'bi-door-open', href: '/admin/rooms/create', accent: '#3b82f6', bg: '#eff6ff' },
    { label: 'Add News', icon: 'bi-newspaper', href: '/admin/news/create', accent: '#8b5cf6', bg: '#f5f3ff' },
    { label: 'Add Gallery', icon: 'bi-images', href: '/admin/gallery/create', accent: '#10b981', bg: '#ecfdf5' },
    { label: 'Edit Homepage', icon: 'bi-house', href: '/admin/homepage', accent: '#f59e0b', bg: '#fffbeb' },
    { label: 'Testimonials', icon: 'bi-chat-quote', href: '/admin/testimonials/create', accent: '#06b6d4', bg: '#ecfeff' },
    { label: 'Settings', icon: 'bi-gear', href: '/admin/settings', accent: '#64748b', bg: '#f8fafc' },
];

const formatDate = (date) => {
    if (!date) return '—';
    return new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};

const statusStyle = (status) => {
    const map = {
        confirmed: { bg: '#f0fdf4', color: '#16a34a', dot: '#22c55e' },
        pending:   { bg: '#fffbeb', color: '#d97706', dot: '#f59e0b' },
        cancelled: { bg: '#fef2f2', color: '#dc2626', dot: '#ef4444' },
    };
    return map[status] || { bg: '#f8fafc', color: '#64748b', dot: '#94a3b8' };
};
</script>

<template>
    <AdminLayout>
        <template #title>Dashboard</template>

        <!-- Welcome banner -->
        <div class="rounded-2xl p-6 mb-6 flex items-center justify-between overflow-hidden relative mt-1" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); box-shadow: 0 4px 24px rgba(15,23,42,0.18);">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, #f59e0b 0%, transparent 60%);"></div>
            <div class="relative z-10">
                <p class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-1">Welcome back</p>
                <h2 class="text-white text-2xl font-bold mb-1">{{ $page.props.auth?.user?.name || 'Admin' }}</h2>
                <p class="text-slate-400 text-sm">Here's what's happening at Alexandar Palace today.</p>
            </div>
            <div class="hidden sm:flex items-center gap-3 relative z-10">
                <Link href="/admin/bookings" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white border border-white/10 hover:bg-white/10 transition-colors">
                    <i class="bi bi-calendar-check"></i> View Bookings
                </Link>
                <Link href="/" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-900 hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="bi bi-box-arrow-up-right"></i> View Site
                </Link>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <Link
                v-for="stat in statCards"
                :key="stat.label"
                :href="stat.href"
                class="bg-white rounded-2xl p-5 border border-slate-100 hover:shadow-lg transition-all duration-200 hover:-translate-y-1 group cursor-pointer"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.06);"
            >
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" :style="`background: ${stat.bg};`">
                        <i class="bi text-lg" :class="stat.icon" :style="`color: ${stat.accent};`"></i>
                    </div>
                    <div class="text-xs font-medium px-2 py-1 rounded-lg" :style="`background: ${stat.bg}; color: ${stat.accent};`">
                        <i class="bi bi-arrow-up-right text-xs"></i>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 mb-1 tracking-tight">{{ stat.value }}</div>
                <div class="text-sm font-semibold text-slate-700">{{ stat.label }}</div>
                <div class="text-xs text-slate-400 mt-0.5">{{ stat.trend }}</div>
            </Link>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-6" style="box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest" style="letter-spacing: 0.08em;">Quick Actions</h3>
            </div>
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                <Link
                    v-for="action in quickActions"
                    :key="action.label"
                    :href="action.href"
                    class="flex flex-col items-center gap-2.5 p-3 rounded-xl border border-slate-100 hover:border-transparent transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md group"
                    :style="`--accent: ${action.accent};`"
                >
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors group-hover:scale-110 duration-200" :style="`background: ${action.bg};`">
                        <i class="bi text-lg" :class="action.icon" :style="`color: ${action.accent};`"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 text-center leading-tight">{{ action.label }}</span>
                </Link>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <!-- Recent Bookings -->
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                <div class="px-5 py-4 flex items-center justify-between" style="border-bottom: 1px solid #f1f5f9;">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: #fffbeb;">
                            <i class="bi bi-calendar-check text-sm" style="color: #f59e0b;"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm">Recent Bookings</h3>
                    </div>
                    <Link href="/admin/bookings" class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors" style="color: #f59e0b; background: #fffbeb;">
                        View all <i class="bi bi-arrow-right ml-1"></i>
                    </Link>
                </div>
                <div>
                    <div v-if="!recent_bookings?.length" class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3" style="background: #f8fafc;">
                            <i class="bi bi-calendar-x text-xl text-slate-300"></i>
                        </div>
                        <p class="text-sm font-medium">No bookings yet</p>
                    </div>
                    <div
                        v-for="booking in recent_bookings"
                        :key="booking.id"
                        class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition-colors"
                        style="border-bottom: 1px solid #f8fafc;"
                    >
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                {{ (booking.name || booking.guest_name || 'G')[0].toUpperCase() }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ booking.name || booking.guest_name || 'Guest' }}</p>
                                <p class="text-xs text-slate-400">{{ formatDate(booking.check_in) }} → {{ formatDate(booking.check_out) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold" :style="`background: ${statusStyle(booking.status).bg}; color: ${statusStyle(booking.status).color};`">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" :style="`background: ${statusStyle(booking.status).dot};`"></span>
                            {{ booking.status || 'pending' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Contacts -->
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                <div class="px-5 py-4 flex items-center justify-between" style="border-bottom: 1px solid #f1f5f9;">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: #fef2f2;">
                            <i class="bi bi-envelope text-sm" style="color: #ef4444;"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm">Recent Messages</h3>
                    </div>
                    <Link href="/admin/contacts" class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors" style="color: #ef4444; background: #fef2f2;">
                        View all <i class="bi bi-arrow-right ml-1"></i>
                    </Link>
                </div>
                <div>
                    <div v-if="!recent_contacts?.length" class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3" style="background: #f8fafc;">
                            <i class="bi bi-inbox text-xl text-slate-300"></i>
                        </div>
                        <p class="text-sm font-medium">No messages yet</p>
                    </div>
                    <div
                        v-for="contact in recent_contacts"
                        :key="contact.id"
                        class="flex items-start gap-3 px-5 py-3.5 hover:bg-slate-50 transition-colors"
                        style="border-bottom: 1px solid #f8fafc;"
                    >
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                            {{ (contact.name || 'G')[0].toUpperCase() }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ contact.name }}</p>
                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <span v-if="!contact.is_read" class="w-2 h-2 rounded-full flex-shrink-0" style="background: #f59e0b;"></span>
                                    <span class="text-xs text-slate-400">{{ formatDate(contact.created_at) }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 truncate mt-0.5">{{ contact.subject || contact.message?.substring(0, 60) || 'No subject' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
