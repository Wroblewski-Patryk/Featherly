<template>
  <div class="relative bg-base-100 min-h-screen flex flex-col mx-auto w-full overflow-x-hidden shadow-2xl" :style="cssVariables">
    <!-- Header Wrapper -->
    <header v-if="activeHeader" class="relative">
      <div class="fixed top-6 right-6 z-[60]">
        <LanguageSwitcher />
      </div>
      <DynamicBlock 
        v-for="(block, index) in activeHeader" 
        :key="'header-'+index" 
        :block="block" 
      />
    </header>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer Wrapper -->
    <footer v-if="activeFooter">
      <DynamicBlock 
        v-for="(block, index) in activeFooter" 
        :key="'footer-'+index" 
        :block="block" 
      />
    </footer>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import DynamicBlock from '@/Components/DynamicBlock.vue'
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue'

const props = defineProps({
  settings: {
    type: Object,
    default: () => ({})
  }
});

const pageProps = usePage().props;

const activeHeader = computed(() => {
  if (pageProps.page?.header_override?.content) return pageProps.page.header_override.content;
  return pageProps.settings?.default_header_content; // Fallback or global header
});

const activeFooter = computed(() => {
  if (pageProps.page?.footer_override?.content) return pageProps.page.footer_override.content;
  return pageProps.settings?.default_footer_content;
});

const cssVariables = computed(() => {
  const brand = pageProps.settings?.brand_colors || {};
  const fonts = pageProps.settings?.brand_fonts || {};
  return {
    '--p': brand.primary || '#4f46e5',
    '--s': brand.secondary || '#10b981',
    '--a': brand.accent || '#f59e0b',
    '--font-heading': fonts.heading ? `"${fonts.heading}", sans-serif` : 'inherit',
    '--font-body': fonts.body ? `"${fonts.body}", sans-serif` : 'inherit',
  };
});

onMounted(() => {
  // Reset the theme to light for the public frontend 
  // so that the admin panel theme (if any) doesn't bleed through
  document.documentElement.setAttribute('data-theme', 'light');
});
</script>
