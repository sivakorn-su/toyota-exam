<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
    topic: {
        id: number;
        title: string;
        content: string;
        is_anonymous: boolean;
    };
}>();

// Initialize the form with the current topic data
const form = useForm({
    title: props.topic.title,
    content: props.topic.content,
    is_anonymous: props.topic.is_anonymous,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Topic List',
        href: '/topics',
    },
    {
        title: 'Edit Topic',
        href: `/topics/${props.topic.id}/edit`,
    },
];

const submitTopic = () => {
    if (form.title.trim() && form.content.trim()) {
        form.put(`/topics/${props.topic.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                window.location.href = `/topics/${props.topic.id}`; // Redirect to the topic page after update
            },
        });
    }
};
</script>

<template>
    <Head title="Edit Topic" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-4">
            <h1 class="text-3xl font-bold">Edit Topic</h1>

            <form @submit.prevent="submitTopic">
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

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.is_anonymous" />
                        <span class="ml-2">Post anonymously</span>
                    </label>
                </div>


                <button
                    type="submit"
                    :disabled="form.processing"
                    class="mt-4 px-6 py-3 bg-blue-600 text-white rounded-md"
                >
                    Update Topic
                </button>
            </form>
        </div>
    </AppLayout>
</template>
