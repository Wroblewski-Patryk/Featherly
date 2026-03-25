<template>
  <Head>
    <title>{{ finalTitle }}</title>
    <meta v-if="description" name="description" :content="description" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:title" :content="finalTitle" />
    <meta v-if="description" property="og:description" :content="description" />
    <meta v-if="finalImageUrl" property="og:image" :content="finalImageUrl" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" :content="finalTitle" />
    <meta v-if="description" property="twitter:description" :content="description" />
    <meta v-if="finalImageUrl" property="twitter:image" :content="finalImageUrl" />
    
    <!-- Canonical -->
    <link v-if="canonical" rel="canonical" :href="canonical" />
    <link
      v-for="(href, localeCode) in normalizedAlternateLocales"
      :key="`alternate-${localeCode}`"
      rel="alternate"
      :hreflang="localeCode"
      :href="href"
    />
    <meta v-if="robots" name="robots" :content="robots" />
    
    <slot />
  </Head>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useTranslations } from '@/Composables/useTranslations'

const props = defineProps({
  title: String,
  full_title: String,
  parent: String,
  description: String,
  image: String,
  canonical: String,
  robots: String,
  alternate_locales: {
    type: Object,
    default: () => ({}),
  },
})

const page = usePage()
const { t } = useTranslations()

const seoSettings = computed(() => page.props.seo_settings || {})

const normalizedAlternateLocales = computed(() => {
  if (!props.alternate_locales || typeof props.alternate_locales !== 'object') {
    return {}
  }

  return Object.fromEntries(
    Object.entries(props.alternate_locales).filter(([_, href]) => typeof href === 'string' && href.trim() !== '')
  )
})

const finalTitle = computed(() => {
  if (props.full_title) return props.full_title

  const brand = t(seoSettings.value.site_name) || import.meta.env.VITE_APP_NAME || 'Featherly'
  let separator = seoSettings.value.title_separator || ' - '
  
  if (separator.trim() === '-' || separator.trim() === '|') {
      separator = ` ${separator.trim()} `
  }

  const order = seoSettings.value.title_order || 'brand_first'
  const pageTitle = t(props.title)

  if (!pageTitle || pageTitle.trim() === '') return brand

  const parts = []
  if (order === 'page_first') {
    parts.push(pageTitle.trim())
    if (props.parent) parts.push(props.parent.trim())
    parts.push(brand.trim())
  } else {
    parts.push(brand.trim())
    if (props.parent) parts.push(props.parent.trim())
    parts.push(pageTitle.trim())
  }
  
  return parts.join(separator)
})

const finalImageUrl = computed(() => {
  if (!props.image) return null;
  if (props.image.startsWith('http')) return props.image;
  return props.image;
})
</script>
