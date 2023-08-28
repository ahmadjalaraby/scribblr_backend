<script setup>
import InputGroup from "@/Components/InputGroup/index.vue";
import {useI18n} from "vue-i18n";
import Switch from "@/Components/Switch/index.vue";

const props = defineProps({
    form: Object,
})

</script>

<template>
    <div class="flex flex-col gap-4">
        <InputGroup
            v-model="props.form.name"
            :error="props.form.errors?.name"
            :label="useI18n().t('dashboard.name')"
            :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.name')})"
            name="name"
            type="text"
        />
        <InputGroup
            v-model="props.form.code"
            :error="props.form.errors?.code"
            :label="useI18n().t('dashboard.code')"
            :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.code')})"
            name="code"
            type="text"
        />
        <InputGroup
            v-model="props.form.start"
            :error="props.form.errors?.start"
            :label="useI18n().t('dashboard.start')"
            :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.start')})"
            name="start"
            type="text"
        />
        <div class="pt-3">
            <Switch v-model="props.form.active"
                    :label="useI18n().t('dashboard.active')"
                    active-class="bg-primary-500"
                    name="active"/>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
