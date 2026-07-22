<script setup>
import { ref, watch } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    room: { type: Object, default: null },
});

const isEdit = !!props.room;
const activeTab = ref('basic');

const tabs = [
    { key: 'basic', label: 'Basic Info', icon: 'bi-info-circle' },
    { key: 'pricing', label: 'Pricing', icon: 'bi-currency-euro' },
    { key: 'amenities', label: 'Amenities', icon: 'bi-check2-square' },
    { key: 'media', label: 'Media', icon: 'bi-images' },
];

const amenityOptions = [
    { key: 'wifi', label: 'Free WiFi', icon: 'bi-wifi' },
    { key: 'ac', label: 'Air Conditioning', icon: 'bi-snow' },
    { key: 'tv', label: 'Flat Screen TV', icon: 'bi-tv' },
    { key: 'minibar', label: 'Mini Bar', icon: 'bi-cup-straw' },
    { key: 'safe', label: 'In-room Safe', icon: 'bi-safe' },
    { key: 'balcony', label: 'Balcony', icon: 'bi-door-open' },
    { key: 'sea_view', label: 'Sea View', icon: 'bi-water' },
    { key: 'city_view', label: 'City View', icon: 'bi-buildings' },
    { key: 'room_service', label: 'Room Service', icon: 'bi-bell' },
    { key: 'breakfast', label: 'Breakfast Included', icon: 'bi-cup-hot' },
    { key: 'jacuzzi', label: 'Jacuzzi', icon: 'bi-droplet' },
    { key: 'bathtub', label: 'Bathtub', icon: 'bi-droplet-half' },
    { key: 'shower', label: 'Rain Shower', icon: 'bi-moisture' },
    { key: 'hairdryer', label: 'Hair Dryer', icon: 'bi-wind' },
    { key: 'iron', label: 'Iron & Board', icon: 'bi-layers' },
    { key: 'desk', label: 'Work Desk', icon: 'bi-laptop' },
];

const form = useForm({
    slug: props.room?.slug || '',
    name: props.room?.name || { en: '', mk: '' },
    description: props.room?.description || { en: '', mk: '' },
    short_description: props.room?.short_description || { en: '', mk: '' },
    price_per_night: props.room?.price_per_night || 0,
    discounted_price: props.room?.discounted_price || null,
    quantity: props.room?.quantity || 1,
    max_guests: props.room?.max_guests || 2,
    bedrooms: props.room?.bedrooms || 1,
    bathrooms: props.room?.bathrooms || 1,
    square_meters: props.room?.square_meters || null,
    bed_type: props.room?.bed_type || 'king',
    view_type: props.room?.view_type || '',
    featured_image: props.room?.featured_image || '',
    gallery_images: props.room?.gallery_images || [],
    amenities: props.room?.amenities || [],
    is_active: props.room?.is_active ?? true,
    is_featured: props.room?.is_featured ?? false,
    sort_order: props.room?.sort_order || 0,
});

const generateSlug = () => {
    if (!isEdit && form.name.en) {
        form.slug = form.name.en
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }
};

watch(() => form.name.en, generateSlug);

const toggleAmenity = (key) => {
    const index = form.amenities.indexOf(key);
    if (index === -1) {
        form.amenities.push(key);
    } else {
        form.amenities.splice(index, 1);
    }
};

const addGalleryImage = () => {
    form.gallery_images.push('');
};

const removeGalleryImage = (index) => {
    form.gallery_images.splice(index, 1);
};

const submit = () => {
    if (isEdit) {
        form.put(`/admin/rooms/${props.room.slug}`);
    } else {
        form.post('/admin/rooms');
    }
};

const bedTypes = [
    { value: 'single', label: 'Single Bed' },
    { value: 'double', label: 'Double Bed' },
    { value: 'queen', label: 'Queen Bed' },
    { value: 'king', label: 'King Bed' },
    { value: 'twin', label: 'Twin Beds' },
];
</script>

<template>
    <AdminLayout>
        <template #title>{{ isEdit ? 'Edit Room' : 'Create Room' }}</template>
        <template #actions>
            <Link href="/admin/rooms" class="btn-secondary mr-3">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                {{ isEdit ? 'Update Room' : 'Create Room' }}
            </button>
        </template>

        <div class="flex gap-6">
            <!-- Tabs Sidebar -->
            <div class="w-56 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <nav class="p-2">
                        <button
                            v-for="tab in tabs"
                            :key="tab.key"
                            @click="activeTab = tab.key"
                            :class="[
                                'w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left transition-colors',
                                activeTab === tab.key 
                                    ? 'bg-amber-50 text-amber-700' 
                                    : 'text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            <i :class="['bi', tab.icon]"></i>
                            <span class="font-medium">{{ tab.label }}</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 max-w-3xl">
                <form @submit.prevent="submit">
                    <!-- Basic Info Tab -->
                    <div v-show="activeTab === 'basic'" class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Information</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">URL Slug *</label>
                                <input 
                                    type="text" 
                                    v-model="form.slug" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                                    required 
                                    :disabled="isEdit"
                                    placeholder="deluxe-suite"
                                >
                                <p class="text-xs text-slate-500 mt-1">Auto-generated from name. Used in URL: /rooms/{{ form.slug || 'slug' }}</p>
                            </div>

                            <BilingualInput v-model="form.name" label="Room Name" required />
                            <BilingualInput v-model="form.short_description" label="Short Description" />
                            <BilingualInput v-model="form.description" label="Full Description" type="textarea" />
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Details</h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Quantity *</label>
                                    <input 
                                        type="number" 
                                        v-model="form.quantity" 
                                        min="1"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                                        required
                                    >
                                    <p class="text-xs text-slate-500 mt-1">Total rooms available</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Max Guests *</label>
                                    <input 
                                        type="number" 
                                        v-model="form.max_guests" 
                                        min="1"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Bedrooms</label>
                                    <input 
                                        type="number" 
                                        v-model="form.bedrooms" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Bathrooms</label>
                                    <input 
                                        type="number" 
                                        v-model="form.bathrooms" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Size (m²)</label>
                                    <input 
                                        type="number" 
                                        v-model="form.square_meters" 
                                        min="0"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    >
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Bed Type</label>
                                <select 
                                    v-model="form.bed_type" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                >
                                    <option v-for="bed in bedTypes" :key="bed.value" :value="bed.value">{{ bed.label }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Visibility</h3>
                            <div class="flex flex-wrap gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        v-model="form.is_active" 
                                        class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                                    >
                                    <span class="text-sm text-slate-700">Active (visible on website)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        v-model="form.is_featured" 
                                        class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                                    >
                                    <span class="text-sm text-slate-700">Featured (show on homepage)</span>
                                </label>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
                                <input 
                                    type="number" 
                                    v-model="form.sort_order" 
                                    class="w-24 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Tab -->
                    <div v-show="activeTab === 'pricing'" class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Pricing</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Price per Night (€) *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">€</span>
                                        <input 
                                            type="number" 
                                            step="0.01" 
                                            v-model="form.price_per_night" 
                                            class="w-full pl-8 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                                            required
                                        >
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Discounted Price (€)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">€</span>
                                        <input 
                                            type="number" 
                                            step="0.01" 
                                            v-model="form.discounted_price" 
                                            class="w-full pl-8 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                            placeholder="Leave empty if no discount"
                                        >
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">If set, original price will show with strikethrough</p>
                                </div>
                            </div>

                            <div v-if="form.discounted_price && form.price_per_night" class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                                <div class="flex items-center gap-2 text-green-700">
                                    <i class="bi bi-tag-fill"></i>
                                    <span class="font-medium">
                                        {{ Math.round((1 - form.discounted_price / form.price_per_night) * 100) }}% discount applied
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities Tab -->
                    <div v-show="activeTab === 'amenities'" class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Amenities</h3>
                            <p class="text-sm text-slate-500 mb-4">Select all amenities available in this room</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <button
                                    v-for="amenity in amenityOptions"
                                    :key="amenity.key"
                                    type="button"
                                    @click="toggleAmenity(amenity.key)"
                                    :class="[
                                        'flex items-center gap-3 p-3 rounded-lg border-2 transition-all text-left',
                                        form.amenities.includes(amenity.key)
                                            ? 'border-amber-500 bg-amber-50 text-amber-700'
                                            : 'border-slate-200 hover:border-slate-300 text-slate-600'
                                    ]"
                                >
                                    <i :class="['bi', amenity.icon, 'text-lg']"></i>
                                    <span class="text-sm font-medium">{{ amenity.label }}</span>
                                    <i 
                                        v-if="form.amenities.includes(amenity.key)" 
                                        class="bi bi-check-circle-fill ml-auto text-amber-500"
                                    ></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Media Tab -->
                    <div v-show="activeTab === 'media'" class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Featured Image</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Image Path</label>
                                <input 
                                    type="text" 
                                    v-model="form.featured_image" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="img/rooms/room_1.jpg"
                                >
                                <p class="text-xs text-slate-500 mt-1">Path relative to /assets/paradise/</p>
                            </div>

                            <div v-if="form.featured_image" class="mt-4">
                                <p class="text-sm font-medium text-slate-700 mb-2">Preview</p>
                                <div class="w-full max-w-md h-48 bg-slate-100 rounded-lg overflow-hidden">
                                    <img 
                                        :src="`/assets/paradise/${form.featured_image}`" 
                                        :alt="form.name.en"
                                        class="w-full h-full object-cover"
                                        @error="$event.target.style.display='none'"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-slate-800">Gallery Images</h3>
                                <button 
                                    type="button"
                                    @click="addGalleryImage"
                                    class="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1"
                                >
                                    <i class="bi bi-plus-circle"></i> Add Image
                                </button>
                            </div>
                            
                            <div v-if="!form.gallery_images.length" class="text-center py-8 text-slate-500">
                                <i class="bi bi-images text-4xl mb-2 block text-slate-300"></i>
                                <p>No gallery images added yet</p>
                            </div>

                            <div v-else class="space-y-3">
                                <div 
                                    v-for="(image, index) in form.gallery_images" 
                                    :key="index"
                                    class="flex items-center gap-3"
                                >
                                    <div class="w-16 h-12 bg-slate-100 rounded overflow-hidden flex-shrink-0">
                                        <img 
                                            v-if="image"
                                            :src="`/assets/paradise/${image}`" 
                                            class="w-full h-full object-cover"
                                            @error="$event.target.style.display='none'"
                                        >
                                    </div>
                                    <input 
                                        type="text" 
                                        v-model="form.gallery_images[index]" 
                                        class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                        placeholder="img/rooms/gallery_1.jpg"
                                    >
                                    <button 
                                        type="button"
                                        @click="removeGalleryImage(index)"
                                        class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

