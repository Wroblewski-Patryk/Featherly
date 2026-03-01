<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
    <Head title="Admin Dashboard" />
    <AdminLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
            <div class="alert alert-info shadow-sm mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Welcome to VueCMS Administrator Panel. You have successfully authenticated.</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title">Pages</h2>
                        <p>Manage your website pages and utilize the Visual Block Builder.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-primary btn-sm">Manage Pages</button>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title">Blog Posts</h2>
                        <p>Write and publish blog articles with full SEO settings.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-primary btn-sm">Manage Posts</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
