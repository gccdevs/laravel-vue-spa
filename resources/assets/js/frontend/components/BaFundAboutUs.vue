<template>
    <div class="funding__about-us hero is-bold is-dark">
        <div class="container">
            <div class="funding__about-us__wrap">
                <div class="funding__about-us__text">
                    <div class="funding__about-us__title">
                        {{ $i18n.t('fund.aboutUs') }}
                        <hr>
                    </div>
                    <blockquote class="funding__about-us__quote">
                        {{ $i18n.t('fund.mainVerse') }}
                    </blockquote>
                    <div class="chinese-script" v-if="isChinese">
                        <br><br>
                        起名榮耀城，便是因為上帝賦予我們教會的異象，我們相信每一個年輕人都是上帝極為看重的，可以成為神合用的器皿，興起發光，在世人面前作神榮耀的見證，成為影響這一整個時代的領袖。我們也相信，教會就是一群合神心意的人聚集在一起，我們雖身在世界，卻可以活出屬天的生活，讓神的榮耀因著榮耀城和众教會，彰顯在這地。
                        <br><br>
                        過去的那六年時間，榮耀城經歷了各樣的祝褔與成長，有100多位弟兄姊妹們參與到我們當中，經歷神的愛，生命被翻轉，又把神的愛繼續傳遞出去。榮耀城透過與十多個非營利機構合作，組織愛心義賣，長城義走，領養貧困兒童，參訪老人院，免費招待大學生，辦公益健康講座等，基於真理，用實際行動活出上帝對這地的深深的愛。
                        <br><br>
                        因著上帝的祝福，榮耀城一直在成長擴張，我們有了越來越大的目標，想去服侍越來越多的華人群體，帶給墨爾本這個城市更多神國的影響力。

                        <div class="funding__about-us__img-wrap">
                            <div class="funding__about-us__img"></div>
                        </div>

                        <br><br>
                        <div class="funding__about-us__highlight">
                            六年後，時間到了！ 神給了我們一個更大的教會場地。
                        </div>
                        <br>
                        為著神給我們的大使命和上帝在我們每一個人身上的帶領和祝福，我們非常興奮可以與你分享我們的異象與感動。
                        <br><br>
                        新教會依然位於墨爾本市中心區域，可容納200多人一起聚會。我們相信這是神要在這裡繼續透過我們更大的祝福這個城市，我們也相信，這不只是我們的感動，因著我們靈裡合一，也一定是非常多弟兄姊妹的感動。
                        <br><br>
                        我們承諾本次募捐活动的资金将全部投入新场地裝修費
                        <br><br>
                        601-603 Elizabeth Street, Melbourne 3000
                    </div>
                    <div class="english-script" v-else>
                        <br>
                        Glory City Church was established by Ps Joseph Chen and his wife, Deborah, with a vision to see a new generation of disciples that will be Salt & Light to the World through everyday discipleship lifestyle, and making impact in all areas of society.
                        <br><br>
                        As an Ethnic Church called to serve Mandarin speaking people (from China, HK, Taiwan, Malaysia, Singapore...etc), we have a strong conviction to help the Chinese community to have a renewed mindset as immigrants to not just take what they came here for, but to be rooted in this land, to love the people of this land, and to bless God's work that is established on this land as the "promised land" for all migrants coming to start a new life.
                        <br><br>
                        We strongly believe that this new place will become a crucial foundation for all the work to be done in this ministry:
                        <br><br>
                        <li><b>Community Centre</b> :: To reach and impact the community around us and in the heart of this wonderful city.</li>
                        <br>
                        <li><b>Healing Centre</b> :: To encourage and restore many lives to live their life to the full according to God's creation plan.</li>
                        <br>
                        <li><b>Training Centre</b> :: To equip disciples and empower leaders to do what God has called them to do, whether in Australia, or being sent overseas.</li>
                        <br>
                        <li><b>Mission Centre</b> :: To establish a network of mission works around Australia, and around the World, especially mobilising the Chinese churches</li>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data () {
            return {
                isChinese: true
            }
        },
        mounted () {
            if (this.$route.query.lang === 'en') {
                this.isChinese = false;
            } else {
                this.isChinese = true;
            }
        }
    }
</script>

<style lang="scss">
    .funding {
        &__about-us {
            position: relative;
            width: 100%;
            padding-top: 100px;
            padding-bottom: 100px;
            min-height: 800px;
            &__wrap {
                margin: 0 auto;
                padding: 0 15px;
                @extend .text-container;
            }
            &__title {
                padding-top: 30px;
                padding-bottom: 30px;
                font-size: 55px;
                font-weight: 800;
                text-align: center;
            }
            &__img-wrap {
                padding-top: 30px;
                max-width: 100%;
            }
            &__img {
                background-image: url("../../../../images/logo-arise-shine.png");
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 100%;
            }
            &__quote {
                margin-top: 10px;
                margin-bottom: 10px;
                padding: 0 1em;
                color: #6a737d;
                border-left: 0.25em solid #dfe2e5;
                font-style: italic;
            }

            &__highlight {
                font-size: 22px;
                font-weight: 500;
            }
        }
    }
    .text-container {
        @media screen and (max-width: 575px) {
            max-width: 100%;
            margin: 0 auto;
        }
        @media (min-width: 576px) and (max-width: 767px) {
            max-width: 85%;
            margin: 0 auto;
        }
        @media (min-width: 768px) and (max-width: 991px) {
            max-width: 80%;
            margin: 0 auto;
        }
        @media (min-width: 768px) and (max-width: 991px) {
            max-width: 75%;
            margin: 0 auto;
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            max-width: 70%;
            margin: 0 auto;
        }
        @media (min-width: 1200px) {
            max-width: 65%;
            margin: 0 auto;
        }
        &--title-1 {
            padding-top: 30px;
            padding-bottom: 30px;
            font-size: 45px;
            font-weight: 600;
        }
        &--title-2 {
            padding-top: 15px;
            padding-bottom: 15px;
            font-size: 32px;
            font-weight: 600;
        }
    }
</style>
