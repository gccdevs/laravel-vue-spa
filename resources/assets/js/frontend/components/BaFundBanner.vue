<template>
    <div class="funding__banner">
        <div class="funding__banner__inner">
            <div class="funding__banner__overlay"></div>
            <div class="funding__banner__image"></div>
            <div class="funding__banner__content">
                <div class="container">
                    <div class="funding__banner__content-wrap">
                        <vue-typed-js :strings="[title]" :typeSpeed="100" :startDelay="750">
                            <div class="funding__banner__text typing"></div>
                        </vue-typed-js>
                        <div class="funding__banner__text--sub" v-text="subTitle">
                        </div>
                        <div class="funding__banner__text--deadline">
                            {{ $i18n.t('fund.targetAmountLabel') }}：A$200,000.00<br>
                        </div>
                        <div class="funding__btn">
                            <button v-scroll-to="'#payment-methods'" class="funding__banner__button">{{ buttonText }}</button>
                            <button @click="showVideo = true" class="funding__banner__button funding__banner__button--outline">{{ $i18n.t('fund.testimonyLabel')}}</button>
                        </div>
                        <div class="funding__banner__share">
                            <ul class="icons">
                                <li>
                                    <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + shareLinkUrl + '&title=我願意成為這個國度擴張計畫的一份子！在思想和真理裝備的基礎上，更加知道怎麼去愛～ 讓這個聚集點能夠繼續祝福到更多的人&description=我願意成為這個國度擴張計畫的一份子！在思想和真理裝備的基礎上，更加知道怎麼去愛～ 讓這個聚集點能夠繼續祝福到更多的人'" target="_blank">
                                        <b-icon class="icon icon-small" icon="facebook" pack="fab" size="is-small" type="is-white"></b-icon>
                                        <b-icon class="icon icon-medium" icon="facebook" pack="fab" size="is-medium" type="is-white"></b-icon>
                                    </a>
                                </li>
                                <li>
                                    <a :href="'http://service.weibo.com/share/share.php?url=' + shareLinkUrl + '&title=我願意成為這個國度擴張計畫的一份子！在思想和真理裝備的基礎上，更加知道怎麼去愛～ 讓這個聚集點能夠繼續祝福到更多的人&pic=&ralateUid=&language=zh_cn'" target="_blank">
                                        <b-icon class="icon icon-small" icon="weibo" pack="fab" size="is-small" type="is-white"></b-icon>
                                        <b-icon class="icon icon-medium" icon="weibo" pack="fab" size="is-medium" type="is-white"></b-icon>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:something@something.com?&bcc=建堂奉献&body=我願意成為這個國度擴張計畫的一份子！在思想和真理裝備的基礎上，更加知道怎麼去愛～ 讓這個聚集點能夠繼續祝福到更多的人!\n\n %E6%88%91%20http%3A//hub.glorycitychurch.com/arise-and-shine" target="_blank">
                                        <b-icon class="icon icon-small" icon="envelope-square" pack="fa" size="is-small" type="is-white"></b-icon>
                                        <b-icon class="icon icon-medium" icon="envelope-square" pack="fa" size="is-medium" type="is-white"></b-icon>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="funding__banner__highlight-text">
            <div class="funding__banner__highlight-text__wrap text-container" id="splitting">
                {{ highlightText }}
            </div>
        </div>
        <b-modal :active.sync="showVideo">
            <div class="video">
                <div class="video__wrap">
                    <iframe width="100%" height="540" src="https://www.youtube.com/embed/Yb_TG3T1h1k" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { VueTypedJs } from 'vue-typed-js'
Vue.use(VueTypedJs)
    export default {
        data () {
            return {
                typeit: false,
                splitting: false,
                showVideo: false,
            }
        },
        props: {
            title: {
                type: String,
                default: ''
            },
            subTitle: {
                type: String,
                default: ''
            },
            buttonText: {
                type: String,
                default: ''
            },
            shareLinkUrl: {
                type: String,
                default: '',
            },
            highlightText: {
                type: String,
                default: '',
            }
        },
        methods: {
            createDonation () {
                if($(window).width() < 415) {
                    window.scrollTo({
                        top: $(window).height() * 1.2,
                        behavior: "smooth"
                    });
                } else {
                    window.scrollTo({
                        top: $(window).height(),
                        behavior: "smooth"
                    });
                }
            },
        }
    }
</script>

<style lang="scss">
.typed-cursor {
        animation-iteration-count: infinite;
        position: relative;
        background-color: white;
        color: transparent;
        @media screen and (max-height: 499px) {
            margin-left: 5px;
            height: 32px !important;
        }
        @media (min-width: 500px) and (max-height: 800px) {
            margin-left: 5px;
            height: 40px !important;
        }
        @media screen and (max-width: 575px) {
            margin-left: 5px;
            height: 30px;
        }
        @media (min-width: 576px) and (max-width: 767px) {
            margin-left: 5px;
            height: 60px;
        }
        @media (min-width: 768px) {
            margin-left: 10px;
            width: 10px;
            height: 70px;
        }
    }
</style>

<style lang="scss" scoped>
    .funding {
        &__btn {
            @media screen and (max-height: 499px) {
            padding-top: 10px;
            }
        }
        &__banner {
            position: relative;
            height: 100vh;
            width: 100%;
            &__inner {
                position: relative;
                width: 100%;
                height: 80vh;
                min-height: 400px;
                background-color: #8645a8;
            }
            &__overlay {
                z-index: 2;
                position: absolute;
                display: block;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-position: center center;
                background-size: cover;
                background-repeat: no-repeat;
                /*opacity: 0.9;*/
                background-image: url("../../../../images/banner-gradient-overlay.png");
                /*background-image: linear-gradient(135deg, #3725d4 0%, lighten(#9b67df, 50%) 71%, lighten(#9b67df, 90%) 100%);*/
            }
            &__image {
                position: absolute;
                top: 0;
                right: 0;
                height: 100%;
                background-image: url("../../../../images/home-banner.jpg");
                background-position: center center;
                -webkit-background-size: cover;
                background-size: cover;
                background-repeat: no-repeat;
                @media screen and (max-width: 991px) {
                    width: 100%;
                }
                @media (min-width: 992px) {
                    width: 70%;
                }
            }
            &__content-wrap {
                @media screen and (max-width: 1087px) {
                    margin-right: 15px;
                    margin-left: 15px;
                }
                @media (min-width: 576px) and (max-width: 1087px) {
                    padding-right: 15px;
                    padding-left: 15px;
                }
            }
            &__text {
                z-index: 11;
                color: white;
                font-weight: 900;
                @media screen and (max-height: 499px) {
                    font-size: 32px !important;
                }
                @media (min-width: 500px) and (max-height: 800px) {
                    font-size: 40px !important;
                }
                @media screen and (max-width: 575px) {
                    font-size: 30px;
                }
                @media (min-width: 576px) and (max-width: 767px) {
                    font-size: 60px;
                }
                @media (min-width: 768px) {
                    font-size: 70px;
                }
                &--deadline {
                    @media screen and (max-height: 499px) {
                        height: 55px !important;
                    }
                }
                &--sub, &--deadline {
                    @media screen and (max-height: 499px) {
                        font-size: 12px !important;
                        padding-bottom: 5px !important;
                    }
                    @media (min-width: 500px) and (max-height: 800px) {
                        font-size: 20px !important;
                    }
                    @media screen and (max-width: 575px) {
                        font-size: 14px;
                    }
                    @media (min-width: 576px) {
                        padding-bottom: 30px;
                        font-size: 30px;
                    }
                }
            }
            &__button {
                &--outline {
                    color: white;
                    border: 2px solid #32325d;
                    background-color: transparent;
                    transition: 0.33s ease-in-out;
                    outline: none;
                    &:hover {
                        border: 2px solid white;
                        outline: none;
                        // background-color:  #32325d !important;
                    }
                }

                border: 2px solid #32325d;
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
                line-height: 1em;
                font-weight: 600;
                letter-spacing: 0.025em;
                text-decoration: none;
                transition: 0.33s ease-in-out;
                @media screen and (max-height: 499px) {
                    padding: 5px 10px !important;
                    font-size: 12px !important;
                }
                @media screen and (max-width: 767px) {
                    padding: 10px 20px;
                    font-size: 14px;
                }
                @media (min-width: 768px) {
                    padding: 12px 43px;
                    font-size: 16px;
                }
                &:hover {
                    cursor: pointer;
                    color: white !important;
                    border: 2px solid white;
                    // background-color: lighten(#32325d, 10%);
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
            &__content-wrap & {
                &__share a, &__text, &__button {
                    @media (min-width: 991px) {
                        transition: 0.22s ease-in-out;
                        opacity: 1;
                    }
                }
            }
            &__content-wrap:hover & {
                &__share a, &__text, &__button {
                    opacity: 1;
                }
            }
            &__content {
                z-index: 3;
                right: 0;
                left: 0;
                position: absolute;
                color: #fff;
                @media screen and (max-height: 899px) {
                    top: 120px;
                }
                @media (min-height: 900px) {
                    top: auto;
                    bottom: 18%;
                }
            }
            &__share {
                .icon-small {
                    @media (min-height: 700px) {
                        display: none;
                    }
                    @media (min-width: 768px) {
                        // display: none;
                    }
                }
                .icon-medium {
                    @media screen and (max-height: 699px) {
                        display: none;
                    }
                    @media screen and (max-width: 767px) {
                        // display: none;
                    }
                }
                position: relative;
                max-width: 100%;
                @media screen and (max-height: 699px) {
                    margin: 10px auto;
                }
                @media (min-height: 700px) {
                    margin: 25px auto;
                }
                ul {
                    padding-left: 0;
                    list-style: none;
                }
                li {
                    display: inline-block;
                    padding-right: 20px;
                    @media (min-height: 700px) {
                        padding-bottom: 20px;
                    }
                    &:last-child {
                        padding-right: 0;
                    }
                }
                a {
                    .fa-2x {
                        @media screen and (max-width: 575px) {
                            font-size: 18px !important;;
                        }
                        @media (min-width: 576px) {
                            font-size: 32px !important;
                        }
                    }
                    text-decoration: none;
                    &:hover {
                        opacity: 1;
                        text-decoration: none;
                    }
                }
            }
            &__highlight-text {
                display: block;
                position: relative;
                height: 20vh;
                background-color: #f1f1f1;
                margin: 0 auto;
                &__wrap {
                    display: inline-block;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-weight: 700;
                    color: #4a4a4a;
                    @media screen and (max-width: 575px) {
                        font-size: 14px;
                        padding-left: 10px;
                        border-left: 0.25em solid #dfe2e5;
                        font-style: italic;
                    }
                    @media (min-width: 576px) and (max-width: 991px) {
                        font-size: 24px;
                    }
                    @media (min-width: 992px) {
                        font-size: 32px;
                    }
                }
            }
        }
    }
</style>
