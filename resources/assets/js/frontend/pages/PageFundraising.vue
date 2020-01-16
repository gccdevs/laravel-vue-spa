<template>
    <div class="funding">
        <ba-page-logo></ba-page-logo>
        <div class="switcher-lang">
            <a :href="url + '/?lang=en'">EN</a> / <a :href="url">中文</a>
        </div>
        <ba-fund-banner
            :title="$i18n.t('fund.title')" 
            :subTitle="$i18n.t('fund.subtitle')"
            :buttonText="$i18n.t('fund.buttonText')"
            :shareLinkUrl="fundingPageUrl"
            :highlightText="$i18n.t('fund.highlightText')">
        </ba-fund-banner>
        <ba-fund-bricks></ba-fund-bricks>
        <div class="funding__payment" id="payment-section">
            <div class="container">
                <!--text wrap-->
                <div class="funding__payment__text-wrap" id="payment-methods">
                    <h3 class="text-container--title-1 text-container">{{ $i18n.t('fund.paymentWays') }}:</h3>
                    <h4 class="text-container--title-2 text-container">
                        <span class="payment-hashtag">#</span> {{ $i18n.t('fund.bankTransfer') }}
                    </h4>
                    <div class="funding__payment__bank-transfer text-container">
                        <div class="funding__payment__bank-transfer__wrap">
                            <div class="funding__payment__bank-transfer__detail">Account Name:</div> <div class="text">Glory City Church of Melbourne Inc.</div><br>
                            <div class="funding__payment__bank-transfer__detail">BSB:</div> <div class="text">033-005</div><br>
                                <div class="funding__payment__bank-transfer__detail">SWIFT CODE:</div> <div class="text">WPACAU2S <b>Or</b> WPACAU2SXXX</div><br>
                                <div class="funding__payment__bank-transfer__detail">Account Number:</div> <div class="text">427741</div><br>
                                <div class="funding__payment__bank-transfer__detail">Instruction:</div> <div class="text">Arise</div><br>
                        </div>
                    </div>
                    <h4 class="text-container--title-2 text-container">
                        <span class="payment-hashtag">#</span> {{ $i18n.t('fund.internetTransfer') }}
                        <span class="help payment-icon">
                            <i class="fab fa-cc-stripe fa-2x" style="color:rgb(119, 74, 153);"></i>
                            <i class="fab fa-cc-visa fa-2x" style="color:rgb(21, 38, 101);"></i>
                            <i class="fab fa-cc-mastercard fa-2x" style="color: rgb(214, 46,43);"></i>
                            <i class="fab fa-cc-amex fa-2x" style="color:rgb(30, 65, 113);"></i>
                            <img class="unionpay" src="https://cloud.githubusercontent.com/assets/19792747/26133881/2bb082be-3add-11e7-97cd-b8a419ffd333.png">
                    </span>
                    </h4>
                    <div class="amount-wrap">
                        <div class="funding__select-amount">
                            <div class="columns is-mobile">
                                <div class="column funding__select-amount__button-wrap" v-for="amount in amounts">
                                    <button @click="highlightAmount(amount)" 
                                        class="funding__select-amount button is-bold funding__select-amount__button" 
                                        :class="isSelectedAmount(amount) ? 'funding__select-amount__button--highlight' : null">
                                        A$ {{ amount }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="funding__payment__label">
                        {{ $i18n.t('fund.inputAmount') }}
                    </div>
                    <div class="funding__payment__other-amount">
                        <input type="number" min="1" v-model="selectedMoney" class="custom-amount">
                        <div role="alert" class="error--text" v-if="hasAmountErr">{{ $i18n.t('fund.amountEnterError') }}</div>
                    </div>
                    <div class="funding__payment__label">
                        {{ $i18n.t('fund.givingAmount') }} <span v-if="showCoveredFee">({{ $i18n.t('fund.transactionFee') }})</span>:
                        <span v-if="selectedMoney && showCoveredFee"> {{ formatMoney(selectedMoneyWithRate, '.', ',') }} </span>
                        <span v-else-if="selectedMoney && !showCoveredFee">{{ formatMoney(selectedMoney, '.', ',') }}</span>
                        <span v-else></span>
                    </div>
                    <ba-fund-stripe
                        :selectedMoney="parseFloat(selectedMoney)"
                        @change="receiveChange"
                        @rateFee="selectRateFee"
                        :hasAmountErr="hasAmountErr">
                    </ba-fund-stripe>
                    <h4 class="text-container--title-2 text-container">
                        <span class="payment-hashtag">#</span> {{ $i18n.t('fund.wechatPay') }}
                    </h4>
                    <div class="funding__paylinx text-container">
                        <div class="help">
                            {{ $i18n.t('fund.paymentWarning') }}
                            <br>{{ $i18n.t('fund.feesAmount') }}。
                        </div>
                        <div class="funding__paylinx__inner">
                            <div class="funding__paylinx__img"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ba-fund-about-us></ba-fund-about-us>
        <div class="funding__footer">
            <div class="funding__footer__wrap">
                <div class="container">
                    © Glory City Church of Melbourne Inc. 2018
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                url: window.APP_URL + '/arise-and-shine/',
                payRate: 0,
                showCoveredFee: false,
                showSwitchPayment: true,
                isUsingStripe: true,
                amounts: [500, 1000, 2000],
                otherMoney: null,
                selectedMoney: 500,
                showQRCode: false,
                slickOptions: {
                    mobileFirst: true,
                    dots: false,
                    swipe: true,
                    arrows: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            }
        },
        computed: {
            hasAmountErr () {
                let result = /^(-?\d+\.\d+)$|^(-?\d+)$/.test(this.selectedMoney);

                if (result) {
                    if (this.selectedMoney <= 0) {
                        return true;
                    }
                } else {
                    return true;
                }

                return false;
            },
            fundingPageUrl () {
                return Laravel.APP_URL + '/arise-and-shine';
            },
            selectedMoneyWithRate () {
                if (this.payRate !== 0) {
                    return parseFloat(this.selectedMoney) + (parseFloat(this.selectedMoney) * this.payRate) + 0.3;
                }
                return parseFloat(this.selectedMoney);
            }
        },
        methods: {
            selectRateFee (val) {
                if (val.selected) {
                    this.showCoveredFee = true;
                } else {
                    this.showCoveredFee = false;
                }

                this.payRate = val.payRate;
            },
            isSelectedAmount (amount) {
                if (this.selectedMoney == amount) {
                    return true;
                }
                return false;
            },
            highlightAmount (val) {
                this.selectedMoney = val;
            },
            formatMoney(number) {
                let n = Number.parseFloat(number).toFixed(2);
                return n.toLocaleString('en-IN', {
                    currency: 'AUD',
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });
            },
            receiveChange (val) {
                if (val.status === 'success') {
                    this.$toasted.success(this.$i18n.t('fund.paidSuccess'), {
                        duration: 8000
                    })
                } else if (val.status === 'unknown server fail') {
                    this.$toasted.error('server error', {
                        duration: 8000
                    })
                }else {
                    this.$toasted.error(this.$i18n.t('fund.paidFailed') + ': ' + val.message, {
                        duration: 8000
                    })
                }
            }
        },
        mounted () {
        }
    }
</script>

<style lang="scss">
    .switcher-lang {
        position: absolute;
        top: 30px;
        right: 30px;
        z-index: 10;
        color: white;
        a {
            color: white;
            text-decoration: none;        
            display: inline-block;
            &:hover {
                color: white;
                text-decoration: none;        
            }
        }
    }
    .funding {
        position: relative;
        &__select-amount {
            margin: 0 auto;
            @media screen and (max-width: 767px) {
                max-width: 100%;
            }
            @media (min-width: 768px) {
                max-width: 450px;
            }
            &__button-wrap {
                @media screen and (max-width: 575px) {
                    padding-left: 0;
                    padding-right: 0;
                }
                margin: 0 auto;
                text-align: center;
            }
            &__button {
                @media screen and (max-width: 575px) {
                    box-shadow: 5px 7px 10px #bebebe;
                }
                @media (min-width: 576px) {
                    box-shadow: 10px 15px 40px rgba(211, 211, 211, 75);
                }
                outline: none;
                background-color: rgb(117, 75, 151);
                border: none;
                color: white;
                &:hover, &:active, &:focus {
                    cursor: pointer;
                    color: white;
                    outline: none;
                    @media screen and (max-width: 575px) {
                        box-shadow: 5px 7px 10px #bebebe;
                    }
                    @media (min-width: 576px) {
                        box-shadow: 10px 15px 40px rgba(211, 211, 211, 75);
                    }
                }
                &--highlight {
                    transition: .22s ease-in-out;
                    transform: scale(1.3);
                    box-shadow: none;
                    outline: none;
                    @media screen and (max-width: 575px) {
                        transform: scale(1.1);
                    }
                    @media (min-width: 576px) {
                        transform: scale(1.3);
                    }
                }
            }
        }
        &__paylinx {
            @media (min-width: 576px) {
                padding-left: 35px;
            }
            &__link {
                a {
                    margin-bottom: 10px;
                    display: block;
                    text-align: center;
                }
            }
            position: relative;
            margin-top: 45px;
            margin-bottom: 25px;
            &__inner {
                max-width: 320px;
                position: relative;
                margin: 10px auto;
                box-shadow: 10px 15px 40px rgba(250, 250, 250, 75);
            }
            &__img {
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                padding-bottom: 155%;
                background-image: url("../../../../images/wechatpay.png");
            }
        }
        &__payment {
            max-width: 100% !important;
            min-height: 800px;
            background-color: rgb(250, 250, 250);
            padding-bottom: 100px;
            &__text-wrap {
                max-width: 100% !important;
                padding: 0 15px;
                margin: 0 auto;
            }
            &__label {
                text-align: center;
                padding-top: 30px;
                padding-bottom: 30px;
                font-size: 18px;
                font-weight: 600;
            }
            &__other-amount {
                margin: 0 auto;
                text-align: center;
            }
            &__is-recurring {
                text-align: center;
                padding-top: 30px;
                padding-bottom: 30px;
                span {
                    font-size: 18px;
                    font-weight: 600;
                }
            }
            &__bank-transfer {
                padding: 12px 0;
                @media (min-width: 576px) {
                    padding-left: 35px;
                }
                &__detail {
                    display: inline-block;
                    font-weight: 700;
                    min-width: 160px;
                }
                &__wrap {
                    .text {
                        @media screen and (max-width: 575px) {
                            display: block;
                            // padding-left: 25px;
                        }
                        @media (min-width: 576px) {
                            display: inline-block;
                        }
                    }
                    br {
                        @media screen and (max-width: 575px) {
                            display: none;
                        }
                    }
                    span {
                        display: block;
                        font-size: 32px;
                        font-weight: 600;
                    }
                }
            }
        }
        &__footer {
            color: white;
            text-transform: uppercase;
            font-weight: 600;
            background-color: rgb(119, 74, 153);
            @media screen and (max-width: 575px) {
                padding-left: 15px;
                padding-right: 15px;
            }
            &__wrap {
                padding-top: 15px;
                padding-bottom: 15px;
            }
        }
        &__copyright {
            padding-bottom: 30px;
        }
    }
    .custom-amount {
        outline: none;
        box-shadow: none;
        &:focus {
            outline: none;
            box-shadow: none;
        }
    }

    .button-disabled {
        background-color: lighten(#32325d, 35%);
        cursor: no-drop;
        &:hover {
            background-color: lighten(#32325d, 35%) !important;
            cursor: no-drop !important;
        }
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    .payment-hashtag {
        color: rgb(119, 74, 153);
        &:hover {
            text-decoration: underline;
        }
    }
    .amount-wrap {
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .unionpay {
        display: inline-block;
        max-width: 33px;
    }
    .payment-icon {
        @media screen and (max-width: 576px) {
            display: block !important;
        }
    }
</style>

