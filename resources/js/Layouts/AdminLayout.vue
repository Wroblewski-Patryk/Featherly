<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

// Themes supported in our DaisyUI configuration
const themes = ['light', 'dark', 'luxury', 'cyberpunk'];
const currentTheme = ref('light');

onMounted(() => {
    // Check localStorage for a saved theme
    const savedTheme = localStorage.getItem('admin-theme');
    if (savedTheme && themes.includes(savedTheme)) {
        currentTheme.value = savedTheme;
    } else {
        // Fallback to media query preference if available, else 'light'
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            currentTheme.value = 'dark';
        }
    }
    
    // Apply theme
    applyTheme(currentTheme.value);
});

watch(currentTheme, (newTheme) => {
    applyTheme(newTheme);
    localStorage.setItem('admin-theme', newTheme);
});

function applyTheme(themeName) {
    document.documentElement.setAttribute('data-theme', themeName);
}
</script>

<template>
    <div class="min-h-screen bg-base-200 text-base-content font-sans">
        <!-- Top Navbar -->
        <div class="navbar bg-base-100 shadow-sm border-b border-base-300 z-50 sticky top-0">
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl font-bold">VueCMS</a>
            </div>
            
            <div class="flex-none gap-2">
                <!-- Theme Switcher Dropdown -->
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                    </label>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-200">
                        <li class="menu-title"><span>Select Theme</span></li>
                        <li v-for="theme in themes" :key="theme">
                            <a :class="{ 'active': currentTheme === theme }" @click="currentTheme = theme">
                                <span class="capitalize">{{ theme }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Admin Profile/Logout Dropdown Placeholder -->
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                        <div class="bg-neutral text-neutral-content rounded-full w-10">
                            <span>AD</span>
                        </div>
                    </label>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-200">
                        <li><a>Settings</a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex h-[calc(100vh-4rem)]">
            <!-- Sidebar Navigation -->
            <div class="drawer lg:drawer-open w-auto z-40 relative">
                <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
                <div class="drawer-side h-full absolute lg:static">
                    <label for="admin-drawer" class="drawer-overlay"></label> 
                    <ul class="menu p-4 w-64 h-full bg-base-100 text-base-content border-r border-base-300">
                        <!-- Sidebar content here -->
                        <li class="menu-title"><span>Content</span></li>
                        <li>
                            <Link href="/admin/pages">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                Pages
                            </Link>
                        </li>
                        <li>
                            <Link href="/admin/posts">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                Blog Posts
                            </Link>
                        </li>
                        <li class="menu-title mt-4"><span>Library</span></li>
                        <li>
                            <Link href="/admin/media">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Media
                            </Link>
                        </li>
                        <li class="menu-title mt-4"><span>System</span></li>
                        <li>
                            <Link href="/admin/settings">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Settings
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-base-200 p-6">
                <!-- Mobile drawer toggle -->
                <div class="lg:hidden mb-4">
                    <label for="admin-drawer" class="btn btn-primary drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        Menu
                    </label>
                </div>

                <div class="max-w-7xl mx-auto rounded-box overflow-hidden shadow-sm border border-base-300 bg-base-100">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>
