<template>
    <Head :title="t('dashboard.languages')" />
    <h2>{{ model }}</h2>
    <Link :href="route('dashboard')">{{ t('dashboard.languages') }}</Link>

</template>


<script setup>
import {Head, Link} from "@inertiajs/vue3";
import {useI18n} from "vue-i18n";

const {t, locale} = useI18n()

const props = defineProps({
    model: {
        type: Object,
        required: true,
    }
})

</script>
