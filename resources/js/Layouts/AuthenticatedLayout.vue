<template>
    <main class="app-wrapper">
        <Header :class="window.width > 1280 ? switchHeaderClass() : ''"/>
        <!-- end header -->

        <Sidebar
            v-if="
        useThemeSettingsStore().menuLayout === 'vertical' &&
        useThemeSettingsStore().sidebarHidden === false &&
        window.width > 1280
      "
        />
        <!-- main sidebar end -->
        <Transition name="mobilemenu">
            <mobile-sidebar
                v-if="window.width < 1280 && useThemeSettingsStore().mobielSidebar"
            />
        </Transition>
        <Transition name="overlay-fade">
            <div
                v-if="window.width < 1280 && useThemeSettingsStore().mobielSidebar"
                class="overlay bg-slate-900 bg-opacity-70 backdrop-filter backdrop-blur-[3px] backdrop-brightness-10 fixed inset-0 z-[999]"
                @click="useThemeSettingsStore().mobielSidebar = false"
            ></div>
        </Transition>

        <div
            :class="window.width > 1280 ? switchHeaderClass() : ''"
            class="content-wrapper transition-all duration-150"
        >
            <div
                :class="routeVar.meta?.appheight ? 'h-full' : 'page-min-height'"
                class="page-content"
            >
                <div
                    :class="` transition-all duration-150 ${
            useThemeSettingsStore().cWidth === 'boxed'
              ? 'container mx-auto'
              : 'container-fluid'
          }`"
                >
                    <Breadcrumbs v-if="!routeVar.meta?.hide"/>
                    <slot/>
                </div>
            </div>
        </div>
        <!-- end page content -->
        <FooterMenu v-if="window.width < 768"/>
        <Footer
            v-if="window.width > 768"
            :class="window.width > 1280 ? switchHeaderClass() : ''"
        />
    </main>
</template>
<script setup>
import {useThemeSettingsStore} from "@/store/themeSettings";
import Breadcrumbs from "@/components/Breadcrumbs/index.vue";
import Footer from "../components/Footer/index.vue";
import Header from "../components/Header/index.vue";
import Sidebar from "../components/Sidebar/index.vue";
import MobileSidebar from "@/components/Sidebar/MobileSidebar.vue";
import FooterMenu from "@/components/Footer/FooterMenu.vue";
import useWindowSize from "@/Composables/useWindow";
import useRoute from "@/Composables/useRoute";


const routeVar = useRoute()
const window = useWindowSize()

const switchHeaderClass = () => {
    if (
        useThemeSettingsStore().menuLayout === "horizontal" ||
        useThemeSettingsStore().sidebarHidden
    ) {
        console.log('wadwad')
        return "ltr:ml-0 rtl:mr-0";
    } else if (useThemeSettingsStore().sidebarCollasp) {
        return "ltr:ml-[72px] rtl:mr-[72px]";
    } else {
        return "ltr:ml-[248px] rtl:mr-[248px]";
    }
}
</script>

<style lang="scss">
.router-animation-enter-active {
    animation: coming 0.2s;
    animation-delay: 0.1s;
    opacity: 0;
}

.router-animation-leave-active {
    animation: going 0.2s;
}

@keyframes going {
    from {
        transform: translate3d(0, 0, 0) scale(1);
    }
    to {
        transform: translate3d(0, 4%, 0) scale(0.93);
        opacity: 0;
    }
}

@keyframes coming {
    from {
        transform: translate3d(0, 4%, 0) scale(0.93);
        opacity: 0;
    }
    to {
        transform: translate3d(0, 0, 0) scale(1);
        opacity: 1;
    }
}

@keyframes slideLeftTransition {
    0% {
        opacity: 0;
        transform: translateX(-20px);
    }
    100% {
        opacity: 1;
        transform: translateX(0px);
    }
}

.mobilemenu-enter-active {
    animation: slideLeftTransition 0.24s;
}

.mobilemenu-leave-active {
    animation: slideLeftTransition 0.24s reverse;
}

.page-content {
    @apply md:pt-6 md:pb-[37px] md:px-6 pt-[15px] px-[15px] pb-24;
}

.page-min-height {
    min-height: calc(var(--vh, 1vh) * 100 - 132px);
}
</style>
