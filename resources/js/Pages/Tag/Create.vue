<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div class="grid xl:grid-cols-2 gap-5">
            <Card :title="detailsTitle">
                <TagFormDetails :form="form"/>
            </Card>
            <div class="card-auto-height space-y-5 order-first sm:order-last">
                <Card :title="contentTitle">
                    <TagFormContent :form="form"/>
                </Card>
            </div>
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
import TagFormDetails from '@/Pages/Tag/Components/Create/TagFormDetails.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";

const {t} = useI18n();

const pageTitle = computed(() => t('dashboard.tags_create'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const createBtnText = computed(() => t('dashboard.create'));

const dashboardTitle = computed(() => t('validation.required',
    {attribute: t('dashboard.title')}));

const formSchema = yup.object({
    title: yup
        .string()
        .required(dashboardTitle.value),
});

const form = useForm({
    title: null,
    active: true,
    image: null,
});

const handleSubmit = async () => {
    form.clearErrors();
    try {
        await formSchema.validate(form.data(), {abortEarly: false});
        if (form.processing) {
            return false
        }
        form.post(route('tags.store'), {
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
