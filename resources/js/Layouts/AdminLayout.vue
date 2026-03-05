<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ThemeStyleProvider from '@/Components/ThemeStyleProvider.vue';
import { PhFileText, PhFeather, PhCards, PhTextbox, PhPaintRoller, PhCube, PhLayout, PhList, PhImageSquare, PhGlobe, PhTranslate, PhGear, PhBell } from '@phosphor-icons/vue';

defineProps({
    fullWidth: {
        type: Boolean,
        default: false
    }
});

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
    <ThemeStyleProvider />
    <div class="min-h-screen bg-base-200 text-base-content font-sans">
        <!-- Top Navbar -->
        <div class="navbar bg-base-100/80 backdrop-blur-md shadow-lg border-b border-base-300 z-50 sticky top-0 px-4">
            <div class="flex-1">
                <Link href="/admin/" class="btn btn-ghost normal-case hover:bg-transparent flex items-center gap-1 group w-fit px-2">
                    <div class="h-8 w-8 bg-gradient-to-r from-primary to-accent" 
                         style="mask: url('/img/featherly-sygnet.svg') no-repeat center / contain; -webkit-mask: url('/img/featherly-sygnet.svg') no-repeat center / contain; background-size: 160px 100%; background-position: left center;">
                    </div>
                    <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent text-2xl font-normal tracking-wide m-auto pr-1"
                          style="background-size: 160px 100%; background-position: -44px center;">
                        Featherly
                    </span>
                </Link>
            </div>
            
            <div class="flex-none gap-2">
                <!-- Theme Switcher Dropdown -->
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                    </label>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-200">
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
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-200">
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
                <div class="drawer-side h-full absolute lg:static shadow-xl lg:shadow-none">
                    <label for="admin-drawer" class="drawer-overlay"></label> 
                    <ul class="menu p-4 w-64 h-full bg-base-100/80 backdrop-blur-md text-base-content border-r border-base-200 gap-1">
                        <!-- Sidebar content here -->
                        <li class="menu-title mt-2 mb-2 border-b border-base-200/50 pb-1"><span class="text-[10px] uppercase font-bold tracking-widest text-primary/60">Content</span></li>
                        <li>
                            <Link href="/admin/pages" class="group hover:bg-primary/5 hover:text-primary transition-all bg-transparent" :class="{ 'text-primary font-medium border-r-2 border-primary rounded-r-none': $page.url.startsWith('/admin/pages') }">
                                <PhFileText weight="regular" class="w-5 h-5 transition-colors" :class="{'text-primary': $page.url.startsWith('/admin/pages'), 'text-base-content/50 group-hover:text-primary': !$page.url.startsWith('/admin/pages')}" />
                                Pages
                            </Link>
                        </li>
                        <li>
                            <details :open="['/admin/posts'].some(p => $page.url.startsWith(p))">
                                <summary class="group hover:bg-primary/5 hover:text-primary transition-all font-medium bg-transparent"><PhFeather weight="regular" class="w-5 h-5 transition-colors" :class="{'text-primary': $page.url.startsWith('/admin/posts') || $page.url.startsWith('/admin/categories'), 'text-base-content/50 group-hover:text-primary': !($page.url.startsWith('/admin/posts') || $page.url.startsWith('/admin/categories'))}" /> Posts</summary>
                                <ul>
                                    <li><Link href="/admin/posts" class="group hover:bg-primary/5 hover:text-primary transition-all bg-transparent" :class="{ 'text-primary font-medium border-r-2 border-primary rounded-r-none': $page.url === '/admin/posts' || $page.url.startsWith('/admin/posts/') }">All Posts</Link></li>
                                    <li><Link href="#" class="group hover:bg-primary/5 hover:text-primary transition-all bg-transparent" :class="{ 'text-primary font-medium border-r-2 border-primary rounded-r-none': $page.url.startsWith('/admin/categories') }">Categories</Link></li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <Link href="/admin/projects" class="group hover:bg-primary/5 hover:text-primary transition-all bg-transparent" :class="{ 'text-primary font-medium border-r-2 border-primary rounded-r-none': $page.url.startsWith('/admin/projects') }">
                                <PhCards weight="regular" class="w-5 h-5 transition-colors" :class="{'text-primary': $page.url.startsWith('/admin/projects'), 'text-base-content/50 group-hover:text-primary': !$page.url.startsWith('/admin/projects')}" />
                                Projects
                            </Link>
                        </li>
                        <li>
                            <Link href="/admin/forms" class="group hover:bg-primary/5 hover:text-primary transition-all bg-transparent" :class="{ 'text-primary font-medium border-r-2 border-primary rounded-r-none': $page.url === '/admin/forms' || $page.url.startsWith('/admin/forms/') }">
                                <PhTextbox weight="regular" class="w-5 h-5 transition-colors" :class="{'text-primary': $page.url.startsWith('/admin/forms'), 'text-base-content/50 group-hover:text-primary': !$page.url.startsWith('/admin/forms')}" />
                                Forms
                            </Link>
                        </li>
                        
                        <li class="menu-title mt-6 mb-2 border-b border-base-200/50 pb-1"><span class="text-[10px] uppercase font-bold tracking-widest text-secondary/60">Design</span></li>
                        <li>
                            <details :open="['/admin/theme/colors', '/admin/theme/fonts', '/admin/theme/typography', '/admin/theme/sizes', '/admin/theme/effects'].includes($page.url)">
                                <summary class="group hover:bg-secondary/5 hover:text-secondary transition-all font-medium bg-transparent"><PhPaintRoller weight="regular" class="w-5 h-5 transition-colors" :class="{'text-secondary': ['/admin/theme/colors', '/admin/theme/fonts', '/admin/theme/typography', '/admin/theme/sizes', '/admin/theme/effects'].includes($page.url), 'text-base-content/50 group-hover:text-secondary': !['/admin/theme/colors', '/admin/theme/fonts', '/admin/theme/typography', '/admin/theme/sizes', '/admin/theme/effects'].includes($page.url)}" /> Theme</summary>
                                <ul>
                                    <li><Link href="/admin/theme/colors" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url === '/admin/theme/colors' }">Colors</Link></li>
                                    <li><Link href="/admin/theme/fonts" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url === '/admin/theme/fonts' }">Fonts</Link></li>
                                    <li><Link href="/admin/theme/typography" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url === '/admin/theme/typography' }">Typography</Link></li>
                                    <li><Link href="/admin/theme/sizes" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url === '/admin/theme/sizes' }">Sizes / Metrics</Link></li>
                                    <li><Link href="/admin/theme/effects" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url === '/admin/theme/effects' }">Effects</Link></li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <Link href="/admin/blocks" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url === '/admin/blocks' }">
                                <PhCube weight="regular" class="w-5 h-5 transition-colors" :class="{'text-secondary': $page.url === '/admin/blocks', 'text-base-content/50 group-hover:text-secondary': $page.url !== '/admin/blocks'}" />
                                Blocks
                            </Link>
                        </li>
                        <li>
                            <Link href="/admin/templates" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url.startsWith('/admin/templates') }">
                                <PhLayout weight="regular" class="w-5 h-5 transition-colors" :class="{'text-secondary': $page.url.startsWith('/admin/templates'), 'text-base-content/50 group-hover:text-secondary': !($page.url.startsWith('/admin/templates'))}" />
                                Templates
                            </Link>
                        </li>
                        <li>
                            <Link href="/admin/menus" class="group hover:bg-secondary/5 hover:text-secondary transition-all bg-transparent" :class="{ 'text-secondary font-medium border-r-2 border-secondary rounded-r-none': $page.url.startsWith('/admin/menus') }">
                                <PhList weight="regular" class="w-5 h-5 transition-colors" :class="{'text-secondary': $page.url.startsWith('/admin/menus'), 'text-base-content/50 group-hover:text-secondary': !($page.url.startsWith('/admin/menus'))}" />
                                Menus
                            </Link>
                        </li>
                        
                        <li class="menu-title mt-6 mb-2 border-b border-base-200/50 pb-1"><span class="text-[10px] uppercase font-bold tracking-widest text-accent/60">Library</span></li>
                        <li>
                            <Link href="/admin/media" class="group hover:bg-accent/5 hover:text-accent transition-all bg-transparent" :class="{ 'text-accent font-medium border-r-2 border-accent rounded-r-none': $page.url.startsWith('/admin/media') }">
                                <PhImageSquare weight="regular" class="w-5 h-5 transition-colors" :class="{'text-accent': $page.url.startsWith('/admin/media'), 'text-base-content/50 group-hover:text-accent': !($page.url.startsWith('/admin/media'))}" />
                                Media
                            </Link>
                        </li>
                        
                        <li class="menu-title mt-6 mb-2 border-b border-base-200/50 pb-1"><span class="text-[10px] uppercase font-bold tracking-widest text-base-content/50">System</span></li>
                        <li>
                            <Link href="/admin/languages" class="group hover:bg-base-content/5 hover:text-base-content transition-all bg-transparent" :class="{ 'text-base-content font-medium border-r-2 border-base-content rounded-r-none': $page.url.startsWith('/admin/languages') }">
                                <PhGlobe weight="regular" class="w-5 h-5 transition-colors" :class="{'text-base-content': $page.url.startsWith('/admin/languages'), 'text-base-content/50 group-hover:text-base-content': !($page.url.startsWith('/admin/languages'))}" />
                                Languages
                            </Link>
                        </li>
                        <li>
                            <Link href="/admin/translations" class="group hover:bg-base-content/5 hover:text-base-content transition-all bg-transparent" :class="{ 'text-base-content font-medium border-r-2 border-base-content rounded-r-none': $page.url.startsWith('/admin/translations') }">
                                <PhTranslate weight="regular" class="w-5 h-5 transition-colors" :class="{'text-base-content': $page.url.startsWith('/admin/translations'), 'text-base-content/50 group-hover:text-base-content': !($page.url.startsWith('/admin/translations'))}" />
                                Translations
                            </Link>
                        </li>
                        <li>
                            <Link href="/admin/settings" class="group hover:bg-base-content/5 hover:text-base-content transition-all bg-transparent" :class="{ 'text-base-content font-medium border-r-2 border-base-content rounded-r-none': $page.url.startsWith('/admin/settings') }">
                                <PhGear weight="regular" class="w-5 h-5 transition-colors" :class="{'text-base-content': $page.url.startsWith('/admin/settings'), 'text-base-content/50 group-hover:text-base-content': !($page.url.startsWith('/admin/settings'))}" />
                                Settings
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-base-200" :class="{ 'p-6': !fullWidth }">
                <!-- Mobile drawer toggle -->
                <div class="lg:hidden" :class="{ 'mb-4': !fullWidth, 'p-4 border-b border-base-300': fullWidth }">
                    <label for="admin-drawer" class="btn btn-primary drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        Menu
                    </label>
                </div>

                <div :class="{ 'max-w-7xl mx-auto': !fullWidth, 'h-full flex flex-col': fullWidth }">
                    <!-- Header Section if provided -->
                    <div v-if="$slots.header" :class="[fullWidth ? 'm-4' : 'mb-6', 'p-6 bg-base-100 rounded-box shadow-sm border border-base-300']">
                        <slot name="header"></slot>
                    </div>

                    <div :class="{ 'h-full flex-1': fullWidth }">
                        <slot></slot>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
