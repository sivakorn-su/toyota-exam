<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link,useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

// Props from controller
defineProps<{
    topics: {
        id: number;
        title: string;
        content: string;
        is_anonymous: boolean;
        user?: {
            name: string;
        };
    }[];
    authUser: any;
    flash?: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Topic List',
        href: '/topics',
    },
];
const deleteTopic = (id: number) => {
    if (confirm('Are you sure you want to delete this topic?')) {
        useForm({}).delete(route('topics.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Topic List" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold mb-4">Topics</h1>
                    <Link
                        :href="route('topics.create')"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    >
                        Create Topic
                    </Link>
                </div>

                <!-- Flash message -->
                <div v-if="flash" class="mb-4 rounded bg-green-100 p-3 text-green-800">
                    {{ flash }}
                </div>

                <!-- Topics list -->
                <ul class="space-y-4">
                    <li
                        v-for="topic in topics"
                        :key="topic.id"
                        class="rounded border p-4 shadow-sm"
                    >
                        <Link :href="route('topics.show', topic.id)" class="text-gray-300 hover:text-blue-600 underline">
                            <span class="font-semibold text-2xl">{{ topic.title }}</span>
                        </Link>
                        <p class="mt-1 text-sm text-gray-700">{{ topic.content }}</p>
                        <div class="mt-2 text-xs text-gray-500">
                            Posted by:
                            <span>
                                {{ topic.is_anonymous ? 'Anonymous' : (topic.user?.name || 'Unknown') }}
                            </span>
                        </div>

                        <!-- Edit button if the user is the author of the topic -->
                        <div v-if="authUser && authUser.id === topic.user?.id" class="mt-2 items-end">
                            <Link
                                :href="route('topics.edit', topic.id)"
                                class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
                            >
                                Edit Topic
                            </Link>
                            <button
                                @click="deleteTopic(topic.id)"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900  text-left"
                            >
                                Delete
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
