<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div class="grid xl:grid-cols-1 gap-5">
            <Card :title="detailsTitle">
                <CountryFormDetails :form="form"/>
            </Card>
<!--            <div class="card-auto-height space-y-5 order-first sm:order-last">-->
<!--                <Card :title="contentTitle">-->
<!--                    <TagFormContent :form="form"/>-->
<!--                </Card>-->
<!--            </div>-->
        </div>
        <div class="mt-8 px-32">
            <Button :text="createBtnText" btnClass="btn-primary block-btn mt-4" type="submit"/>
        </div>
    </form>
</template>


<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {useToast} from 'vue-toastification';
import * as yup from 'yup';
import Card from '@/Components/Card/index.vue';
import Button from '@/Components/Button/index.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";
import CountryFormDetails from "@/Pages/Country/Components/CountryFormDetails.vue";

const {t} = useI18n();

const pageTitle = computed(() => t('dashboard.countries_create'));
const detailsTitle = computed(() => t('dashboard.details'));
const createBtnText = computed(() => t('dashboard.create'));

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
    name: null,
    code: null,
    start: null,
    active: 1,
});

const handleSubmit = async () => {
    form.clearErrors();
    try {
        await formSchema.validate(form.data(), {abortEarly: false});
        if (form.processing) {
            return false
        }
        form.post(route('countries.store'), {
            preserveScroll: true,
            onError: (error) => {
                toast.error(t('error.something_happened'), {
                    timeout: 2000,
                });
                console.log(error);
            },
            onSuccess: () => {
                form.reset();
                toast.success(t('dashboard.successfully_added'), {
                    timeout: 2000,
                });
            },
        })
        ;
    } catch (error) {
        console.log(error)
        if (error.inner) {
            const errors = {};
            error.inner.forEach((e) => {
                errors[e.path] = e.message;
            });
            form.setError(errors);
        }
    }
};

const toast = useToast();
</script>

<style scoped>

</style>
