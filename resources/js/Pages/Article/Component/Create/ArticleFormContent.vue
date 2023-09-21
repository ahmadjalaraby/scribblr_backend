<script setup>
import InputGroup from "@/Components/InputGroup/index.vue";
import FromGroup from "@/Components/FromGroup/index.vue";
import Select from "@/Components/Select/index.vue";
import {useI18n} from "vue-i18n";
import {genderOptions} from "@/constant/gender";
import flatPickr from 'vue-flatpickr-component';
import {computed} from "vue";
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Switch from "@/Components/Switch/index.vue";


const props = defineProps({
    form: Object,
    tags: Object,
    status: Array,
});

const tags = computed(() => props.tags.map(tag => {
    return {
        value: tag.id,
        label: tag.title,
    }
}));

const status = computed(() => props.status.map(state => {
    return {
        value: state,
        label: useI18n().t(`dashboard.${state}`)
    }
}));

const translatedGenderOptions = computed(() => {
    return genderOptions.map(option => ({
        value: option.value,
        label: useI18n().t(option.label),
    }));
});

</script>

<template>
    <div class="flex flex-col gap-4">
        <div class=" flex flex-col gap-4 max-w-2xl">
            <InputGroup
                v-model="props.form.title"
                :error="props.form.errors?.title"
                :label="useI18n().t('dashboard.title')"
                :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.title')})"
                name="title"
                type="text"
            />

            <FromGroup :label="useI18n().t('dashboard.publish_time')" name="publish_time">
                <flat-pickr
                    id="publish_time"
                    v-model="props.form.publish_time"
                    :config="{
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i',
                }"
                    class="form-control"
                    name="publish_time"
                    placeholder="Y-m-d H:i"
                />
                <p v-if="props.form.errors?.publish_time" class="mt-2 text-danger-500 block text-sm">
                    {{ props.form.errors?.publish_time }}
                </p>
            </FromGroup>

            <Select v-model="props.form.status"
                    :error="props.form.errors?.status"
                    :label="useI18n().t('dashboard.status')"
                    :options="status"
                    :placeholder="useI18n().t('dashboard.select_option')"/>


            <Select
                v-model="props.form.tag_id"
                :error="props.form.errors?.tag_id"
                :label="useI18n().t('dashboard.tag')"
                :options="tags"
                :placeholder="useI18n().t('dashboard.select_option')"/>


            <Switch
                v-model="props.form.allow_comments"
                :label="useI18n().t('dashboard.allow_comments')"
                name="allow_comments"/>
        </div>

        <FromGroup :label="useI18n().t('dashboard.content')" name="content">
            <QuillEditor v-model:content="props.form.content"
                         class="classinput input-group-control min-h-full"
                         content-type="html"
                         toolbar="full"/>
        </FromGroup>

    </div>
</template>

<style lang="scss" scoped>

</style>
