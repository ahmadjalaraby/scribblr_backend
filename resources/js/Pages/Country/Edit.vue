<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div v-if="countryImage" class="grid xl:grid-cols-1 gap-3 mb-4">
            <div class="card-auto-height space-y-5">
                <Card :title="contentTitle">
                    <Image
                        :src="countryImage"
                        alt="Small image with fluid-grow:"
                        imageClass="rounded-md w-full h-24"
                    />
                </Card>
            </div>
        </div>
        <div class="grid xl:grid-cols-1 gap-3">
            <Card :title="detailsTitle">
                <CountryFormDetails :form="form"/>
            </Card>
        </div>
        <div class="mt-8 px-32">
            <Button :text="editBtnText" btnClass="btn-primary block-btn mt-4" type="submit"/>
        </div>
    </form>
</template>
<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {useToast} from 'vue-toastification';
import * as yup from 'yup';
import Card from '@/Components/Card/index.vue';
import Image from '@/Components/Image/index.vue';
import Button from '@/Components/Button/index.vue';
import TagFormDetails from '@/Pages/Tag/Components/Create/TagFormDetails.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";
import {router} from '@inertiajs/vue3'
import useImageUrl from "@/Composables/useImageUrl";
import useCountryImageUrl from "@/Composables/useCountryImageUrl";
import CountryFormDetails from "@/Pages/Country/Components/CountryFormDetails.vue";

const {t} = useI18n();
const toast = useToast();

const props = defineProps({
    country: {
        type: Object,
        required: true,
    },
    errors: Object,
});


const countryImage = computed(
    () => useCountryImageUrl(props.country.country.code.toLowerCase()).imageUrl,
);

const pageTitle = computed(() => t('dashboard.countries_edit'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const editBtnText = computed(() => t('dashboard.edit'));

const dashboardTitle = computed(() => t('validation.required',
    {attribute: t('dashboard.title')}));
const requiredField = (value) => t('validation.required',
    {attribute: t('dashboard.' + value)});

const formSchema = yup.object({
    name: yup
        .string()
        .required(requiredField('name')),
    code: yup
        .string()
        .min(2)
        .max(2)
        .required(requiredField('code')),
    start: yup
        .string()
        .required(requiredField('start')),
});

const form = useForm({
    id: props.country.country.id,
    name: props.country.country.name,
    code: props.country.country.code,
    start: props.country.country.start,
    active: props.country.country.active == 1,
    _method: 'put',
});

const handleSubmit = async () => {
    await formSchema.validate(form, {abortEarly: false});

    if (form.processing) {
        return false;
    }

    console.log(form.data());

    form.post(`/countries/${props.country.country.id}`, {
        preserveScroll: true,
        // forceFormData: !!form.image,
        onError: (error) => {
            toast.error(t('error.something_happened'), {
                timeout: 2000,
            });
            console.log(error);
            console.log(form.data());
        },
        onSuccess: () => {
            toast.success(t('dashboard.successfully_updated'), {
                timeout: 2000,
            });
        },
    })
}

</script>
