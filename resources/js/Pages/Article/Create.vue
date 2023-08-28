<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {useToast} from 'vue-toastification';
import * as yup from 'yup';
import Card from '@/Components/Card/index.vue';
import Button from '@/Components/Button/index.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";
import UserFormContent from "@/Pages/User/Components/Create/UserFormContent.vue";
import ArticleFormContent from "@/Pages/Article/Component/Create/ArticleFormContent.vue";

const {t} = useI18n();


const props = defineProps({
    model: {
        required: true,
        type: Object,
    }
});

const pageTitle = computed(() => t('dashboard.articles_create'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const createBtnText = computed(() => t('dashboard.create'));

const requiredField = (value) => t('validation.required',
    {attribute: t('dashboard.' + value)});

const form = useForm({
    title: null,
    content: null,
    status: null,
    publish_time: null,
    allow_comments: true,
    tag_id: null,
    image: null,
});

const formSchema = yup.object({
    title: yup
        .string()
        .required(requiredField('title')),
    content: yup
        .string()
        .nullable(),
    status: yup
        .string()
        .oneOf(props.model.status)
        .required(requiredField('status')),
    publish_time: yup
        .date()
        .required(requiredField('publish_time')),
    tag_id: yup
        .number()
        .required(requiredField('tag')),
    allow_comments: yup
        .boolean()
        .default(true),
});


const handleSubmit = async () => {
    form.clearErrors();
    try {
        await formSchema.validate(form.data(), {abortEarly: false});
        if (form.processing) {
            return false
        }
        form.post(route('articles.store'), {
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


<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div class="grid xl:grid-cols-1 gap-5">
            <Card :title="detailsTitle">
                <ArticleFormContent
                    :form="form"
                    :status="props.model.status"
                    :tags="props.model.tags"/>
            </Card>
            <div class="space-y-5 order-first">
                <Card :title="contentTitle">
                    <TagFormContent :form="form"/>
                </Card>
            </div>
        </div>
        <div class="mt-8 px-32">
            <Button :text="createBtnText" btnClass="btn-primary block-btn" type="submit"/>
        </div>

        <div>
            {{ props.model }}
        </div>
    </form>
</template>

<style lang="scss" scoped>

</style>
