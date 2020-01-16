<template>
    <div>
        <v-switch color="primary" v-model="currentFormBuilder.has_payment" :label="$t('FormBuilder.hasPayment')"></v-switch>
        <transition name="slide-fade">
            <v-layout v-if="currentFormBuilder.has_payment" row wrap>
                <v-flex xs6 offset-xs3>
                    <v-text-field
                            :label="$t('FormBuilder.amount') + ' * (AUD)'"
                            prepend-icon="attach_money"
                            :rules="[rules.required, rules.number, rules.decimals]"
                            v-model="currentFormBuilder.payment.amount">
                    </v-text-field>
                </v-flex>
                <v-flex xs6 offset-xs3>
                    <v-text-field
                            prepend-icon="description"
                            v-model="currentFormBuilder.payment.description"
                            :hint="$t('FormBuilder.optional')"
                            :label="$t('FormBuilder.otherDescription')">
                    </v-text-field>
                </v-flex>
                <v-flex xs6 offset-xs3>
                    <v-card-title style="padding-left: 0;">
                        <b>{{ $t('FormBuilder.coupon') }}</b>
                        <v-icon style="padding-left: 10px;" @click="toggleEditCoupons">add_circle_outline</v-icon>
                    </v-card-title>
                    <ul class="option-list" style="padding-left: 45px;" v-for="(coupon,n) in currentFormBuilder.payment.coupon" :key="n">
                        <li class="option-list__single">
                            <span>{{ coupon.code }}</span> = <span>{{ coupon.amount }}</span>
                            <span class="option-list__remove" @click="removeOption(coupon)"><v-icon>delete_outline</v-icon></span>
                        </li>
                    </ul>
                </v-flex>
                <v-flex class="option-list__add-new" v-if="showEditingCoupons" pl-5 offset-xs3>
                    <v-layout row wrap>
                        <v-flex xs4>
                            <v-text-field
                                    prepend-icon="event_notes"
                                    :label="$t('FormBuilder.coupon')"
                                    v-model="newCoupon.code">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs4>
                            <v-text-field
                                    :label="$t('FormBuilder.amount')"
                                    prepend-icon="money"
                                    :rules="[rules.required, rules.number, rules.decimals, rules.max]"
                                    v-model="newCoupon.amount" >
                            </v-text-field>
                        </v-flex>
                        <v-flex xs3 pt-3>
                            <v-chip @click="ifPressEnter" color="primary" text-color="white" small hover><v-icon>arrow_back</v-icon>{{ $t('FormBuilder.popupConfirm') }}</v-chip>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </transition>
        <v-divider v-if="currentFormBuilder.has_payment"></v-divider>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';
    export default {
        data () {
            return {
                showEditingCoupons: false,
                newCoupon: {
                    code: null,
                    amount :0.00
                },
                rules: {
                    number: value => (!isNaN(value) && value > 0) || this.$t('FormBuilder.incorrectAmount'),
                    required: value => !!value || this.$t('FormBuilder.required'),
                    decimals: value => this.decimalPlaces(parseFloat(value)) <= 2 || 'Incorrect decimal digits, at most 2 decimal digits.',
                    max: value => value <= this.currentFormBuilder.payment.amount || 'Exceeds original amount',
                }
            }
        },
        watch: {
            currentFormBuilder: function () {
                if (this.currentFormBuilder.payment && this.currentFormBuilder.payment.amount) {
                    this.currentFormBuilder.payment.amount = parseFloat(this.currentFormBuilder.payment.amount).toFixed(2);
                }
            }
        },
        computed: {
            ...mapState('FormBuilder', [
                'currentFormBuilder',
            ]),
        },
        methods: {
            ...mapActions('FormBuilder', [
                'onChangeFormFieldAttribute'
            ]),
            decimalPlaces(num) {
                let match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if (!match) { return 0; }
                return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
            },
            toggleEditCoupons () {
                this.showEditingCoupons = !this.showEditingCoupons;
                return this.showEditingCoupons;

            },
            ifPressEnter () {
                // do something here
                this.showEditingCoupons = false;
                if (!this.newCoupon.code || !this.newCoupon.amount) return;
                this.currentFormBuilder.payment.coupon.push(this.newCoupon);

                this.newCoupon = {
                    code: null,
                    amount: null
                }
            }
        }
    }
</script>

<style lang="scss">
    .option-list {
        &__remove {
            display: none;
        }

        &__single {
            min-height: 25px;
            text-align: left;
            &:hover {
                padding-right: 5px;
                .option-list__remove {
                    display: inline-block;
                }
            }
        }
        &__add-new-code {
        }
        &__add-new-amount {
        }
    }
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-leave-active {
        transition: all .3s ease;
    }
    .slide-fade-enter-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>
