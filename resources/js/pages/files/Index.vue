<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { File, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";

interface Props {
    files: {
        data: Array<File>;
        current_page: number;
        last_page: number;
        links: Array<any>;
    };
}
defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Files',
        href: '/files',
    },
];

</script>

<template>

    <Head title="Files" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left">Filename</TableHead>
                            <TableHead class="text-left">Size</TableHead>
                            <TableHead class="text-left">Processed</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="file in files.data">
                            <TableCell>{{ file.filename }}</TableCell>
                            <TableCell>{{ file.size }}</TableCell>
                            <TableCell>{{ file.processed }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <div class="w-full flex justify-center">
                    <div class="mt-4 flex gap-2">
                        <button v-for="link in files.links" :key="link.label" :disabled="!link.url"
                            @click="$inertia.get(link.url)" v-html="link.label" class="px-2 py-1 border rounded"
                            :class="{ 'bg-gray-200': link.active }" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
