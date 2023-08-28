<template>
    <div>
        <InputGroup
            v-model="props.form.title"
            :error="props.form.errors?.title"
            :label="useI18n().t('dashboard.title')"
            :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.title')})"
            name="title"
            type="text"
        />
        <div class="pt-3">
            <Switch
                    :label="useI18n().t('dashboard.active')"
                    active-class="bg-primary-500"
                    :active="props.form.active"
                    name="active"/>
        </div>
    </div>

</template>

<script setup>
import InputGroup from "@/Components/InputGroup/index.vue";
import {useI18n} from "vue-i18n";
import Switch from "@/Components/Switch/index.vue";

const props = defineProps({
    form: Object,
})

</script>
