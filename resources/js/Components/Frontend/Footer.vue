<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const form = useForm({
    email: '',
});

const subscribed = ref(false);

const submitNewsletter = () => {
    form.post('/newsletter/subscribe', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            subscribed.value = true;
            setTimeout(() => { subscribed.value = false; }, 5000);
        },
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
                        <li>Blvd. 8th September No. 15<br>Skopje, Macedonia<br><br></li>
                        <li><strong><a href="mailto:info@aleksandarpalace.com.mk">info@aleksandarpalace.com.mk</a></strong></li>
                        <li><strong><a href="mailto:sales@aleksandarpalace.com.mk">sales@aleksandarpalace.com.mk</a></strong></li>
                        <li><strong><a href="tel:+38923092392">+389 (2) 3092 392</a></strong></li>
                    </ul>
                    <div class="social">
                        <ul>
                            <li><a href="https://www.facebook.com/hotelaleksandarpalace" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/hotelaleksandarpalace/" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a></li>
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
                            <li><Link href="/restaurant">{{ t('nav.restaurant') }}</Link></li>
                            <li><Link href="/news">{{ t('nav.news') }}</Link></li>
                            <li><Link href="/contacts">{{ t('nav.contact') }}</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div id="newsletter">
                        <h5>{{ t('footer.newsletter') }}</h5>
                        <div v-if="subscribed" class="alert" style="background: rgba(40,167,69,0.2); border: 1px solid rgba(40,167,69,0.5); color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                            <i class="bi bi-check-circle me-2"></i>{{ $page.props.locale === 'mk' ? 'Успешно се претплативте!' : 'Successfully subscribed!' }}
                        </div>
                        <form v-else @submit.prevent="submitNewsletter">
                            <div class="form-group">
                                <input type="email" v-model="form.email" class="form-control newsletter-input" :placeholder="t('footer.newsletter_placeholder')" required>
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
