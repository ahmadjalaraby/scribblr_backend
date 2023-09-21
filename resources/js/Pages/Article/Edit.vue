<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {useToast} from 'vue-toastification';
import * as yup from 'yup';
import Card from '@/Components/Card/index.vue';
import Button from '@/Components/Button/index.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";
import ArticleFormContent from "@/Pages/Article/Component/Create/ArticleFormContent.vue";
import Image from "@/Components/Image/index.vue";
import useImageUrl from "@/Composables/useImageUrl";

const {t} = useI18n();


const props = defineProps({
    model: {
        required: true,
        type: Object,
    }
});

const pageTitle = computed(() => t('dashboard.articles_edit'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const createBtnText = computed(() => t('dashboard.edit'));

const requiredField = (value) => t('validation.required',
    {attribute: t('dashboard.' + value)});

const form = useForm({
    id: props.model.article.id,
    title: props.model.article.title,
    content: props.model.article.content,
    status: props.model.article.status,
    publish_time: props.model.article.publish_time,
    allow_comments: props.model.article.allow_comments == 1,
    tag_id: props.model.article.tag_id,
    image: null,
    _method: 'put',
});


const articleImage = computed(
    () => props.model.article.image != null ? useImageUrl(props.model.article.image.path).imageUrl : null,
);

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
});


const handleSubmit = async () => {
    form.clearErrors();
    try {
        await formSchema.validate(form.data(), {abortEarly: false});
        if (form.processing) {
            return false
        }
        form.post(route('articles.update', props.model.article.id), {
            preserveScroll: true,
            onError: (error) => {
                toast.error(t('error.something_happened'), {
                    timeout: 2000,
                });
                console.log(error);
            },
            onSuccess: () => {
                toast.success(t('dashboard.successfully_updated'), {
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
        <div v-if="articleImage" class="grid xl:grid-cols-1 gap-3 mb-4">
            <div class="card-auto-height space-y-5">
                <Card :title="contentTitle">
                    <Image
                        :src="articleImage"
                        alt="Small image with fluid-grow:"
                        imageClass="rounded-md w-full "
                    />
                </Card>
            </div>
        </div>
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
            {{ props.model.article }}
        </div>
    </form>
</template>

<style lang="scss" scoped>

</style>
