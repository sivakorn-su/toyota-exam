<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem, type Comment } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
    topic: {
        id: number;
        title: string;
        content: string;
        is_anonymous: boolean;
        user: {
            name: string;
        };
        comments: Comment[];
    };
    authUser: any;
}>();

const topic = props.topic;

const form = useForm({
    comment: '',
    is_anonymous: false,
});

const submitComment = () => {
    if (form.comment.trim()) {
        form.post(`/topics/${topic.id}/comments`, {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                window.location.reload();
            },
        });
    }
};
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Topic List',
        href: '/topics',
    },
    {
        title: 'Topic '+ topic.title,
        href: '/topics'+topic.id,
    },
];
</script>

<template>
    <Head title="Topic Details" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-4">
            <h1 class="text-3xl font-bold">{{ topic.title }}</h1>
            <p>{{ topic.content }}</p>
            <p class="text-sm text-gray-500">
                Posted by: {{ topic.is_anonymous ? 'Anonymous' : topic.user.name }}
            </p>

            <div class="mt-8">
                <h2 class="text-xl font-semibold">Comments</h2>

                <div v-for="comment in topic.comments" :key="comment.id" class="border-b py-4">
                    <p class="font-semibold">
                        {{ comment.is_anonymous ? 'Anonymous' : comment.user?.name }}:
                    </p>
                    <p>{{ comment.content }}</p>
                </div>

                <div v-if="authUser" class="mt-6">
                <textarea
                    v-model="form.comment"
                    placeholder="Add a comment..."
                    class="w-full p-2 border rounded-md"
                />
                    <label class="block mt-2 mb-4">
                        <input type="checkbox" v-model="form.is_anonymous" />
                         Comment anonymously
                    </label>

                    <button
                        @click="submitComment"
                        :disabled="form.processing"
                        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md"
                    >
                        Post Comment
                    </button>

                    <p v-if="form.errors.comment" class="text-sm text-red-600">
                        {{ form.errors.comment }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>

</template>
