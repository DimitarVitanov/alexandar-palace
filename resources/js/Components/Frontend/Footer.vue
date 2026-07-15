<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const form = useForm({
    email: '',
});

const submitNewsletter = () => {
    form.post('/contacts', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <footer class="revealed">
        <div class="footer_bg">
            <div class="gradient_over"></div>
            <div class="background-image" data-background="url(/assets/paradise/img/footer.webp)"></div>
        </div>
        <div class="container">
            <div class="row move_content">
                <div class="col-lg-4 col-md-12">
                    <h5>{{ t('footer.contacts') }}</h5>
                    <ul>
                        <li>Baker Street 567, Los Angeles 11023<br>California - US<br><br></li>
                        <li><strong><a href="mailto:info@alexandarpalace.com">info@alexandarpalace.com</a></strong></li>
                        <li><strong><a href="tel://43443242232">+434 43242232</a></strong></li>
                    </ul>
                    <div class="social">
                        <ul>
                            <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                            <li><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
                            <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ms-lg-auto">
                    <h5>{{ t('footer.explore') }}</h5>
                    <div class="footer_links">
                        <ul>
                            <li><Link href="/">{{ t('nav.home') }}</Link></li>
                            <li><Link href="/about">{{ t('nav.about') }}</Link></li>
                            <li><Link href="/rooms">{{ t('nav.rooms') }}</Link></li>
                            <li><Link href="/news">{{ t('nav.news') }}</Link></li>
                            <li><Link href="/contacts">{{ t('nav.contact') }}</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div id="newsletter">
                        <h5>{{ t('footer.newsletter') }}</h5>
                        <form @submit.prevent="submitNewsletter">
                            <div class="form-group">
                                <input type="email" v-model="form.email" class="form-control" :placeholder="t('footer.newsletter_placeholder')" required>
                                <button type="submit" :disabled="form.processing"><i class="bi bi-send"></i></button>
                            </div>
                        </form>
                        <p>{{ t('footer.newsletter_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy">
            <div class="container">
                {{ t('footer.copyright') }}
            </div>
        </div>
    </footer>
</template>
