<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    categories: Array,
});

const showCategoryModal = ref(false);
const showItemModal = ref(false);
const editingCategory = ref(null);
const editingItem = ref(null);
const selectedCategoryId = ref(null);

const categoryForm = useForm({
    name: { en: '', mk: '' },
    banner_title: { en: '', mk: '' },
    banner_subtitle: { en: '', mk: '' },
    banner_description: { en: '', mk: '' },
    banner_image: '',
    sort_order: 0,
    is_active: true,
});

const itemForm = useForm({
    name: { en: '', mk: '' },
    description: { en: '', mk: '' },
    price: 0,
    image: '',
    large_image: '',
    sort_order: 0,
    is_active: true,
});

const openCategoryModal = (category = null) => {
    editingCategory.value = category;
    if (category) {
        categoryForm.name = category.name || { en: '', mk: '' };
        categoryForm.banner_title = category.banner_title || { en: '', mk: '' };
        categoryForm.banner_subtitle = category.banner_subtitle || { en: '', mk: '' };
        categoryForm.banner_description = category.banner_description || { en: '', mk: '' };
        categoryForm.banner_image = category.banner_image || '';
        categoryForm.sort_order = category.sort_order || 0;
        categoryForm.is_active = category.is_active ?? true;
    } else {
        categoryForm.reset();
    }
    showCategoryModal.value = true;
};

const openItemModal = (categoryId, item = null) => {
    selectedCategoryId.value = categoryId;
    editingItem.value = item;
    if (item) {
        itemForm.name = item.name || { en: '', mk: '' };
        itemForm.description = item.description || { en: '', mk: '' };
        itemForm.price = item.price || 0;
        itemForm.image = item.image || '';
        itemForm.large_image = item.large_image || '';
        itemForm.sort_order = item.sort_order || 0;
        itemForm.is_active = item.is_active ?? true;
    } else {
        itemForm.reset();
    }
    showItemModal.value = true;
};

const saveCategory = () => {
    if (editingCategory.value) {
        categoryForm.put(`/admin/menu/categories/${editingCategory.value.id}`, {
            onSuccess: () => {
                showCategoryModal.value = false;
                categoryForm.reset();
            },
        });
    } else {
        categoryForm.post('/admin/menu/categories', {
            onSuccess: () => {
                showCategoryModal.value = false;
                categoryForm.reset();
            },
        });
    }
};

const saveItem = () => {
    if (editingItem.value) {
        itemForm.put(`/admin/menu/items/${editingItem.value.id}`, {
            onSuccess: () => {
                showItemModal.value = false;
                itemForm.reset();
            },
        });
    } else {
        itemForm.post(`/admin/menu/categories/${selectedCategoryId.value}/items`, {
            onSuccess: () => {
                showItemModal.value = false;
                itemForm.reset();
            },
        });
    }
};

const deleteCategory = (category) => {
    if (confirm(`Delete category "${category.name?.en}"? This will also delete all items in this category.`)) {
        router.delete(`/admin/menu/categories/${category.id}`);
    }
};

const deleteItem = (item) => {
    if (confirm(`Delete item "${item.name?.en}"?`)) {
        router.delete(`/admin/menu/items/${item.id}`);
    }
};
</script>

<template>
    <Layout title="Restaurant Menu">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Restaurant Menu Management</h1>
                <button @click="openCategoryModal()" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Add Category
                </button>
            </div>

            <div v-for="category in categories" :key="category.id" class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
                <div class="p-4 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">{{ category.name?.en }} / {{ category.name?.mk }}</h2>
                        <p class="text-sm text-slate-500">{{ category.items?.length || 0 }} items</p>
                    </div>
                    <div class="flex gap-2">
                        <button @click="openItemModal(category.id)" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-sm flex items-center gap-1">
                            <i class="bi bi-plus"></i> Add Item
                        </button>
                        <button @click="openCategoryModal(category)" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button @click="deleteCategory(category)" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-slate-500 border-b">
                                <th class="pb-2">Image</th>
                                <th class="pb-2">Name (EN)</th>
                                <th class="pb-2">Name (MK)</th>
                                <th class="pb-2">Price</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in category.items" :key="item.id" class="border-b last:border-0">
                                <td class="py-2">
                                    <img v-if="item.image" :src="`/assets/paradise/${item.image}`" class="w-12 h-12 object-cover rounded" />
                                    <div v-else class="w-12 h-12 bg-slate-200 rounded flex items-center justify-center text-slate-400">
                                        <i class="bi bi-image"></i>
                                    </div>
                                </td>
                                <td class="py-2">{{ item.name?.en }}</td>
                                <td class="py-2">{{ item.name?.mk }}</td>
                                <td class="py-2">${{ item.price }}</td>
                                <td class="py-2">
                                    <span :class="item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-0.5 rounded text-xs">
                                        {{ item.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-2 text-right">
                                    <button @click="openItemModal(category.id, item)" class="text-blue-600 hover:text-blue-800 mr-2">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button @click="deleteItem(item)" class="text-red-600 hover:text-red-800">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!category.items?.length">
                                <td colspan="6" class="py-4 text-center text-slate-400">No items in this category</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="!categories?.length" class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                <p class="text-slate-500 mb-4">No menu categories yet.</p>
                <button @click="openCategoryModal()" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
                    Create First Category
                </button>
            </div>
        </div>

        <!-- Category Modal -->
        <Teleport to="body">
            <div v-if="showCategoryModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="showCategoryModal = false">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-slate-200">
                        <h3 class="text-lg font-semibold">{{ editingCategory ? 'Edit Category' : 'Add Category' }}</h3>
                    </div>
                    <form @submit.prevent="saveCategory" class="p-6 space-y-4">
                        <BilingualInput v-model="categoryForm.name" label="Category Name" required />
                        <BilingualInput v-model="categoryForm.banner_subtitle" label="Banner Subtitle" />
                        <BilingualInput v-model="categoryForm.banner_title" label="Banner Title" />
                        <BilingualInput v-model="categoryForm.banner_description" label="Banner Description" />
                        <div>
                            <label class="block text-sm font-medium mb-1">Banner Image Path</label>
                            <input v-model="categoryForm.banner_image" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="img/restaurant/banner_bg.jpg" />
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1">Sort Order</label>
                                <input v-model="categoryForm.sort_order" type="number" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                            </div>
                            <div class="flex items-center gap-2 pt-6">
                                <input v-model="categoryForm.is_active" type="checkbox" id="cat-active" class="rounded" />
                                <label for="cat-active" class="text-sm">Active</label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="showCategoryModal = false" class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50">Cancel</button>
                            <button type="submit" :disabled="categoryForm.processing" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 disabled:opacity-50">
                                {{ categoryForm.processing ? 'Saving...' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>

        <!-- Item Modal -->
        <Teleport to="body">
            <div v-if="showItemModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="showItemModal = false">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-slate-200">
                        <h3 class="text-lg font-semibold">{{ editingItem ? 'Edit Menu Item' : 'Add Menu Item' }}</h3>
                    </div>
                    <form @submit.prevent="saveItem" class="p-6 space-y-4">
                        <BilingualInput v-model="itemForm.name" label="Item Name" required />
                        <BilingualInput v-model="itemForm.description" label="Description" />
                        <div>
                            <label class="block text-sm font-medium mb-1">Price ($)</label>
                            <input v-model="itemForm.price" type="number" step="0.01" min="0" class="w-full border border-slate-300 rounded-lg px-3 py-2" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Image Path</label>
                                <input v-model="itemForm.image" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="img/restaurant/1.jpg" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Large Image Path</label>
                                <input v-model="itemForm.large_image" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="img/restaurant/large/1.jpg" />
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1">Sort Order</label>
                                <input v-model="itemForm.sort_order" type="number" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                            </div>
                            <div class="flex items-center gap-2 pt-6">
                                <input v-model="itemForm.is_active" type="checkbox" id="item-active" class="rounded" />
                                <label for="item-active" class="text-sm">Active</label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="showItemModal = false" class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50">Cancel</button>
                            <button type="submit" :disabled="itemForm.processing" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 disabled:opacity-50">
                                {{ itemForm.processing ? 'Saving...' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </Layout>
</template>
