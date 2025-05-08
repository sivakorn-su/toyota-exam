<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const form = useForm({
    title: '',
    content: '',
    is_anonymous: false,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Topic List',
        href: '/topics',
    },
    {
        title: 'Create Topic',
        href: '/topics/create',
    },
];

const submitTopic = () => {
    if (form.title.trim() && form.content.trim()) {
        form.post('/topics', {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                window.location.href = '/topics'; // Redirect to topics list after successful creation
            },
        });
    }
};
</script>

<template>
    <Head title="Create Topic" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-4">
            <h1 class="text-3xl font-bold">Create a New Topic</h1>

            <form @submit.prevent="submitTopic">
                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-lg font-medium">Title</label>
                    <input
                        id="title"
                        type="text"
                        v-model="form.title"
                        class="w-full p-2 border rounded-md"
                        placeholder="Enter topic title"
                    />
                    <p v-if="form.errors.title" class="text-sm text-red-600">
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="block text-lg font-medium">Content</label>
                    <textarea
                        id="content"
                        v-model="form.content"
                        class="w-full p-2 border rounded-md"
                        placeholder="Enter topic content"
                    ></textarea>
                    <p v-if="form.errors.content" class="text-sm text-red-600">
                        {{ form.errors.content }}
                    </p>
                </div>

                <!-- Anonymous Option -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.is_anonymous" />
                        <span class="ml-2">Post anonymously</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="mt-4 px-6 py-3 bg-blue-600 text-white rounded-md"
                >
                    Create Topic
                </button>
            </form>
        </div>
    </AppLayout>
</template>
