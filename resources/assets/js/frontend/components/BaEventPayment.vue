<template>
    <div class="event-payment">
        <div class="columns"  id="payment-form">
            <div class="column auto abcdef">
                <label class="label">Email Address</label>
                <input v-model="paymentEmail"
                   class="payment-email-input"
                   :class="!isValidEmail && isDirty ? 'StripeElement--invalid' : null"
                   type="email" :placeholder="'電子郵件'" required>
                <p class="help payment-email-help" v-if="!isValidEmail && isDirty" v-text="'電子郵件不正確'"></p>
            </div>
            <div class="column is-three-fifths">
                <label class="label">Payment Information</label>
                <div id="card-element" ref="card"></div>
                <div id="card-errors" role="alert" class="error--text"></div>
            </div>
        </div>
        <div class="column auto">
            <button @click="createStripeToken" id="submit-button" class="button"  :class="submitLoading ? 'is-loading' : ''" :disabled="canSubmitEvent">Submit Payment</button>
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
                isDirty: false,
                hasEmailError: false,
                paymentEmail: '',
                errorMsg: '',
                card: null,
                submitLoading: false,
            }
        },
        props: {
            isLoading: {
                type: Boolean,
                required: true,
            }
        },
        watch: {
            isLoading (val) {
                this.submitLoading = val;
            },
            paymentEmail(val) {
                if (!this.isDirty) {
                    this.isDirty = true;
                }
            },
        },
        computed: {
            isValidEmail() {
                return !this.isDirty || this.validateEmail(this.paymentEmail);
            },
            canSubmitEvent () {
                return this.submitLoading || (!this.isValidEmail && this.isDirty) || (!this.paymentEmail || this.paymentEmail.length < 3);
            }
        },
        methods: {
            validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            },
            createStripeToken() {
                if (!this.isValidEmail && (this.paymentEmail && this.payerEmail.length > 6)) {
                    this.isDirty = false;
                    this.validateEmail = false;
                    return;
                }
                let self = this;
                self.submitLoading = true;
                stripe.createToken(this.card).then(function(result) {
                    if (result.error) {
                        self.submitLoading = false;
                        let errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        let data = {
                            token: result.token,
                            paymentEmail: self.paymentEmail
                        }
                        self.$emit('change', data);
                    }
                });
            }
        },
        mounted () {
            this.submitLoading = this.isLoading;
            this.card = elements.create('card', {
                // hidePostalCode: true,
                style: style
            });
            this.card.mount(this.$refs.card);
            this.card.addEventListener('change', function(event) {
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
    .event-payment {
        &__title {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        &__fields {
            padding-bottom: 30px;
        }
    }

    /**
     * The CSS shown here will not be introduced in the Quickstart guide, but shows
     * how you can use CSS to style your Element's container.
     */
    .StripeElement {
        background-color: white;
        height: 40px;
        padding: 10px 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 darken(#e6ebf1, 30%);
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
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
    #submit-button {
        border: none;
        border-radius: 4px;
        outline: none;
        text-decoration: none;
        color: #fff;
        background: #32325d;
        white-space: nowrap;
        display: inline-block;
        height: 40px;
        box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
        border-radius: 4px;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.025em;
        text-decoration: none;
        -webkit-transition: all 150ms ease;
        transition: all 150ms ease;
        float: left;
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

</style>