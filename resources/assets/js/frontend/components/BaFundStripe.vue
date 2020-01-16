<template>
    <div class="funding__payment--stripe text-container">
        <div class="funding__event-payment" id="payment-form">
            <div class="column">
                <label class="label">{{ $i18n.t('fund.emailLabel') }}</label>
                <input v-model="paymentEmail"
                    class="payment-email-input"
                    :class="!isValidEmail && paymentEmail ? 'StripeElement--invalid' : null"
                    type="email" :placeholder="$i18n.t('fund.emailLabel')" required>
                    <span class="help">Leave it empty will not receive donation recepit</span>
                <p class="help payment-email-help" v-if="!isValidEmail && paymentEmail" v-text="$i18n.t('fund.emailIncorrect')"></p>
            </div>
            <div class="column">
                <label class="label">{{ $i18n.t('fund.paymentInfo') }} *</label>
                <div id="card-element" ref="donation"></div>
                <div id="card-errors" role="alert" class="error--text"></div>
            </div>
            <div class="column">
                <div class="condition">
                    <div class="field">
                        <b-checkbox v-model="coverTransactionFee" @input="coverFee" v-if="canCheckPayRate">
                            {{ $i18n.t('fund.iWillPay') }}
                        </b-checkbox>
                    </div>
                    <div class="help">1.4% + A$0.30 for domestic Visa / Mastercard transactions</div><br>
                    <div class="help">1.75% + A$0.30 for domestic AMEX transactions</div><br>
                    <div class="help">2.9% + A$0.30 for all other cards (Including Union Pay)</div>
                </div>
            </div>
            <div class="column">
                <button
                        @click="createStripeToken"
                        id="submit-button" class="button funding__button funding__button--small"
                        :class="(submitLoading && hasAmountErr) ? 'is-loading is-disabling' :
                    (
                        (!submitLoading && hasAmountErr) ? 'is-disabling' : 
                        (
                            (submitLoading && !hasAmountErr) ? 'is-loading' : ''
                        )
                    )">
                    Submit Payment
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    let stripe = Stripe(Laravel.StripeKey);
    let elements = stripe.elements();
    let style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    export default {
        data () {
            return {
                cardBrand: '',
                payRate: 0,
                submitLoading: false,
                canPressSubmit: true,
                paymentEmail: '',
                card: null,
                hasEmailError: false,
                errorMsg: '',
                coverTransactionFee: false,
            }
        },
        props: {
            hasAmountErr: {
                type: Boolean,
                required: true
            },
            selectedMoney: {
                type: Number,
                required: true,
            }
        },
        computed: {
            isValidEmail() {
                return this.validateEmail(this.paymentEmail);
            },
            canCheckPayRate () {
                if (this.cardBrand === 'visa' ||
                    this.cardBrand === 'amex' ||
                    this.cardBrand === 'discover' ||
                    this.cardBrand === 'diners' ||
                    this.cardBrand === 'jcb' ||
                    this.cardBrand === 'unionpay' ||
                    this.cardBrand === 'mastercard'){
                    return true;
                } else {
                    return false;
                }
            }
        },
        methods: {
            coverFee(val) {
                this.$emit('rateFee', {'selected': val, payRate: this.payRate});
            },
            validateEmail(email) {
                let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            },
            createStripeToken() {
                let self = this;
                if (this.hasAmountErr) {
                    return;
                }
                if (self.paymentEmail && !self.isValidEmail && !self.canPressSubmit) {
                    let errorElement = document.getElementById('card-errors');
                    errorElement.textContent =  this.$i18n.t('amountEnterError');
                    return;
                }
                self.canPressSubmit = false;
                stripe.createToken(self.card).then(function(result) {
                    if (result.error) {
                        let errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        self.canPressSubmit = true;
                    } else {
                        self.submitLoading = true;
                        let data = {
                            lang: self.$route.query.lang,
                            token: result.token,
                            isCoveringFee: self.coverTransactionFee,
                            payRate: self.payRate,
                            cardBrand: self.cardBrand,
                            paymentEmail: self.paymentEmail && self.isValidEmail ? self.paymentEmail : null,
                            selectedMoney: self.selectedMoney,
                        };
                        // clear card info when click submit
                        self.card.clear();
                        self.handlePostData(data);
                    }
                });
            },
            handlePostData (data) {
                let self = this;
                self.$api.postRoute('fund.charge', {}, data)
                .then(response => {
                    if (response &&
                        response.data &&
                        response.data.data && response.data.data.status === 'succeeded') {
                        self.$emit('change', {
                            status: 'success'
                        });
                    } else {
                        alert(response);
                        self.$emit('change', {
                            status: 'unknown server fail',
                            message: response
                        });
                    }
                    self.paymentEmail = '';
                    self.submitLoading = false;
                    self.canPressSubmit = true;
                }).catch(error => {
                    this.submitLoading = false;
                    self.$emit('change', {
                        status: 'server fail',
                        message: error.response.data.message
                    });
                    self.canPressSubmit = true;
                });
            }
        },
        mounted () {
            let self = this;
            this.card = elements.create('card', {
                style: style
            });
            this.card.mount(this.$refs.donation);
            this.card.addEventListener('change', function(event) {
                if (event.brand && event.brand !== 'unknown') {
                    // visa, mastercard, amex
                    if (event.brand === 'visa' || event.brand == 'mastercard') {
                        self.payRate = 0.014;
                    } else if (event.brand === 'amex') {
                        self.payRate = 0.0175;
                    } else {
                        self.payRate = 0.029;
                    }

                    if (self.cardBrand !== event.brand) {
                        self.cardBrand = event.brand;
                        self.coverTransactionFee = false;
                        self.$emit('rateFee', {'selected': self.coverTransactionFee, payRate: self.payRate});
                    }
                }
                let displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        },
        beforeDestroy() {
            this.card.destroy();
        }
    }
</script>

<style lang="scss">
    #payment-form {
        @media (min-width: 576px) {
            padding-left: 35px;
        }
        .column {
            padding-left: 0;
            padding-right: 0;
        }
    }
    .funding {
        &__payment {
            &--stripe {
                position: relative;
                padding: 40px 0;
            }
        }
        &__button {
            border: none;
            border-radius: 4px;
            outline: none;
            text-decoration: none;
            height: auto;
            color: #fff;
            background: #32325d;
            white-space: nowrap;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
            border-radius: 4px;
            padding: 15px 65px;
            font-size: 28px;
            line-height: 1em;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-decoration: none;
            -webkit-transition: all 150ms ease;
            transition: all 150ms ease;
            &:hover {
                cursor: pointer;
                color: white !important;
                background-color: lighten(#32325d, 10%);
            }
            &--light {
                background: rgb(98, 206, 179);
                &:hover {
                    cursor: pointer;
                    background-color: darken(rgb(98, 206, 179), 10%);
                }
            }
            &--small {
                padding: 10px 25px;
                font-size: 14px;
            }
        }
    }
    .StripeElement, .custom-amount {
        background-color: white;
        height: 40px;
        padding: 10px 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 darken(#e6ebf1, 30%);
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus, .custom-amount:focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a !important;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    .error--text {
        color: #fa755a;
    }
    .payment-email-input {
        background-color: white;
        height: 40px;
        padding: 10px 12px;
        width: 100%;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 darken(#e6ebf1, 30%);
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
        font-size: 14px;

        &:focus {
            /*box-shadow: none !important;*/
            box-shadow: 0 1px 3px 0 darken(#e6ebf1, 60%);
            outline: none !important;
        }
    }
    .payment-email-help {
        color: #fa755a;
    }
    .help {
        display: inline
    }
    .is-disabling {
        background-color: rgb(159, 160, 186);
        cursor: none;
    }
    .condition {
        @media (min-width: 576px) {
        }
    }
</style>
