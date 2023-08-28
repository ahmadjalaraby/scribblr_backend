<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div class="grid xl:grid-cols-2 gap-5">
            <Card :title="detailsTitle">
                <UserFormContent :countries="props.model.countries" :form="form"/>
            </Card>
            <div class="space-y-5 order-first sm:order-last">
                <Card :title="contentTitle">
                    <TagFormContent :form="form"/>
                </Card>
            </div>
        </div>
        <div class="mt-8 px-32">
            <Button :text="createBtnText" btnClass="btn-primary block-btn" type="submit"/>
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
import UserFormContent from "@/Pages/User/Components/Create/UserFormContent.vue";

const {t} = useI18n();


const props = defineProps({
    model: {
        required: true,
        type: Object,
    }
});

const pageTitle = computed(() => t('dashboard.users_create'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const createBtnText = computed(() => t('dashboard.create'));

const requiredField = (value) => t('validation.required',
    {attribute: t('dashboard.' + value)});

const form = useForm({
    firstname: null,
    lastname: null,
    username: null,
    email: null,
    date_of_birth: null,
    gender: null,
    country_id: null,
    image: null,
});

const formSchema = yup.object({
    firstname: yup
        .string()
        .required(requiredField('firstname')),
    lastname: yup
        .string()
        .required(requiredField('lastname')),
    username: yup
        .string()
        .required(requiredField('username')),
    email: yup
        .string()
        .email()
        .required(requiredField('email')),
    gender: yup
        .string()
        .min(1)
        .max(1)
        .oneOf(['m', 'f', 'o'])
        .required(requiredField('gender')),
    date_of_birth: yup
        .date()
        .required(requiredField('date_of_birth')),
    country_id: yup
        .number()
        .required(requiredField('country')),
});

/*
    password: yup
        .string()
        .min(6)
        .required(requiredField('password')),
    password_confirmation: yup
        .string()
        .oneOf([yup.ref('password')], 'Passwords must match')
        .required(requiredField('password_confirmation')),
 */


const handleSubmit = async () => {
    form.clearErrors();
    try {
        await formSchema.validate(form.data(), {abortEarly: false});
        if (form.processing) {
            return false
        }
        form.post(route('users.store'), {
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
