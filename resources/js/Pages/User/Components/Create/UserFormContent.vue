<script setup>
import InputGroup from "@/Components/InputGroup/index.vue";
import FromGroup from "@/Components/FromGroup/index.vue";
import Select from "@/Components/Select/index.vue";
import {useI18n} from "vue-i18n";
import {genderOptions} from "@/constant/gender";
import flatPickr from 'vue-flatpickr-component';
import {computed} from "vue";
// import VueSelect from "@/Components/Select/VueSelect.vue";

const props = defineProps({
    form: Object,
    countries: Array,
});

const countries = computed(() => props.countries.map(country => {
    return {
        value: country.id,
        label: country.name,
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
        <div class="flex flex-row gap-3">
            <InputGroup
                v-model="props.form.firstname"
                :error="props.form.errors?.firstname"
                :label="useI18n().t('dashboard.firstname')"
                :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.firstname')})"
                class="flex-grow"
                name="firstname"
                type="text"
            />
            <InputGroup
                v-model="props.form.lastname"
                :error="props.form.errors?.lastname"
                :label="useI18n().t('dashboard.lastname')"
                :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.lastname')})"
                class="flex-grow"
                name="lastname"
                type="text"
            />
        </div>
        <InputGroup
            v-model="props.form.username"
            :error="props.form.errors?.username"
            :label="useI18n().t('dashboard.username')"
            :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.username')})"
            name="username"
            prepend="@"
            type="text"
        />
        <InputGroup
            v-model="props.form.email"
            :error="props.form.errors?.email"
            :label="useI18n().t('dashboard.email')"
            :placeholder="useI18n().t('validation.type_your', {attribute: useI18n().t('dashboard.email')})"
            name="email"
            type="text"
        />

        <FromGroup :label="useI18n().t('dashboard.date_of_birth')" name="gender">
            <flat-pickr
                id="date_of_birth"
                v-model="props.form.date_of_birth"
                :config="{
                    dateFormat: 'Y-m-d'
                }"
                class="form-control"
                name="date_of_birth"
                placeholder="yyyy, dd M"
            />
            <p v-if="props.form.errors?.date_of_birth" class="mt-2 text-danger-500 block text-sm">
                {{ props.form.errors?.date_of_birth }}
            </p>
        </FromGroup>

        <Select v-model="props.form.gender"
                :error="props.form.errors?.gender"
                :label="useI18n().t('dashboard.gender')"
                :options="translatedGenderOptions"
                :placeholder="useI18n().t('dashboard.select_option')"/>


        <Select
            v-model="props.form.country_id"
            :error="props.form.errors?.country_id"
            :label="useI18n().t('dashboard.country')"
            :options="countries"
            :placeholder="useI18n().t('dashboard.select_option')"/>

    </div>
</template>

<style lang="scss" scoped>

</style>
