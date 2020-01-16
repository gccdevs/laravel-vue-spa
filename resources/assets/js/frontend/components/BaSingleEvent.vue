<template>
    <div>
        <!-- header -->
        <ba-single-event-header :form="form" :src="imageSrc"></ba-single-event-header>
        <!-- form fields -->
        <div class="single-event__form-fields">
            <div class="container">
                <div class="single-event__form-fields__columns columns" v-for="field in form.form_fields">
                    <div class="column is-half is-offset-one-quarter">
                        <ba-single-event-field :field="field" @change="updateEventFieldValue"></ba-single-event-field>
                    </div>
                </div>
                <div class="column is-half is-offset-one-quarter">
                    <hr>
                </div>
                <div class="single-event__form-actions">
                    <div class="column is-half is-offset-one-quarter">
                        <a class="button is-primary is-medium" :class="isSubmitting ? 'is-loading': ''" @click="onSubmit">{{ form.has_payment ? 'Next' : 'Submit' }}</a>
                        <a class="button is-danger is-outlined is-medium">Restart</a>
                    </div>
                </div>
            </div>
            <b-modal
                :active.sync="showPayment"
                :width="680"
                scroll="keep"
                class="modal" :canCancel="['x']">
                <div class="content">
                    <div class="card">
                        <div class="card-content">
                            <div class="is-size-3 modal__title">Event Summary</div>
                            <ba-event-detail-confirm></ba-event-detail-confirm>
                            <p class="help is-info" v-text="' * Please be careful bro.'"></p>
                            <ba-event-payment @change="receiveToken" :isLoading="isStripeBtnLoading"></ba-event-payment>
                        </div>
                    </div>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    export default {
        props: {
            form: {
                type: Object,
                required: true
            }
        },
        data () {
            return {
                isStripeBtnLoading: false,
                fields: {},
                showPayment: false,
                isSubmitting: false,
                paying: false,
                isFinalStepDisabled: true,
            }
        },
        watch: {
            showPayment(val) {
                this.isSubmitting = val;
            }
        },
        computed: {
            imageSrc () {
                let str = this.form.banner_link;
                if (str) {
                    if (str.startsWith('http://') || str.startsWith('https://') || str.startsWith('www.')) {
                        return 'background-image: url("' + str + '")';
                    }
                    return 'background-image: url("https://drive.google.com/uc?id=' + this.form.banner_link + '")';
                } else {
                    return 'background-image: url("../../../../images/logo-main.png")';
                }
            },
            ...mapGetters('Events', {
                event: 'getCurrentEventFields',
            }),
        },
        methods: {
            ...mapActions('Events', [
                'onSubmitEvent',
                'syncEventBasicDetailRequest'
            ]),
            updateEventFieldValue (value) {
                this.fields[value.uuid] = {
                    field_value: value.field_value
                };
            },
            onSubmit () {
                let self = this;
                window.scrollTo(0,0);
                this.isSubmitting = true;

                this.$store.dispatch('Events/UpdateEventFieldsRequest', {fields: self.fields})
                .then(response => {
                    self.isSubmitting = true;

                    if (self.form.has_payment) {
                        self.showPayment = true;
                    } else {
                        self.submitForm();
                    }
                }).catch(err => {
                    self.isSubmitting = false;
                    self.showPayment = false;
                });
            },
            receiveToken(data) {
                this.isStripeBtnLoading = true;
                this.submitForm(data);
            },
            submitForm (token = null) {
                let self = this;
                this.paying = true;

                let data = this.event;
                if (token) {
                    data['stripe_token'] = token.token;
                    data['payment_email'] = token.paymentEmail;
                }

                self.$api.postRoute('event.single.submit', {
                    event: this.form.id
                }, data).then(response => {
                    self.isStripeBtnLoading = false;
                    self.handleSuccess();
                }).catch(err => {
                    self.isStripeBtnLoading = false;
                    console.log(err);
                    self.handleFailure();
                });
            },
            handleSuccess () {
                let self = this;
                this.isSubmitting = false;
                this.$toasted.success('Submitted successfully');
                setTimeout(function () {
                    self.$router.push({name: 'events.home'});
                }, 1200);
            },
            handleFailure () {
                this.paying = false;
                this.isSubmitting = false;
                this.$toasted.error('Failed to submit. Please check your information');
            },
        },
        mounted () {
            if (this.form) {
                this.syncEventBasicDetailRequest({data: this.form});
            }
        }
    }
</script>

<style lang="scss" scoped>
    .single-event {
        &__form-fields {
            padding-top: 65px;
            padding-bottom: 165px;
            &__columns {
                @media screen and (max-width: 768px) {
                    margin: 0 auto;
                    max-width: 100%;
                }
            }
        }
    }
    .modal {
        .card-content {
            @media screen and (max-width: 767px) {
                padding-bottom: 68px;
            }
            @media (min-width: 768px) {
                min-height: 100%;
                padding-bottom: 48px;
            }
        }
        &__title {
            padding-bottom: 30px;
        }
    }
</style>
