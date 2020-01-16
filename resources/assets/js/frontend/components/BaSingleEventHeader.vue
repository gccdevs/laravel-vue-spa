<template>
    <section class="single-event__banner-section hero is-medium is-primary is-bold">
        <div :class="form.banner_link ? 'hero-body hero-body--overlay' : 'hero-body'" :style="src">
            <div class="container">
                <div class="columns">
                    <div class="column is-two-thirds">
                        <h1 class="title">
                            {{ form.form_name }}
                        </h1>
                        <div class="single-event__banner__subtitle subtitle">
                            {{ form.form_description }}
                        </div>
                        <p class="is-size-5">
                        </p>
                    </div>
                    <div class="column">
                        <span class="single-event__banner__subtitle-span">开始日期:</span>
                        <strong>
                            {{ form.start_date }}
                        </strong>
                        <br>
                        <span class="single-event__banner__subtitle-span">开始时间:</span>
                        <strong>
                            {{ form.start_time }}
                        </strong>
                        <br>
                        <span class="single-event__banner__subtitle-span">结束日期:</span>
                        <strong>
                            {{ form.expired_date }}
                        </strong>
                        <br>
                        <span class="single-event__banner__subtitle-span">结束时间:</span>
                        <strong>
                            {{ form.expired_time}}
                        </strong>
                        <hr>
                        <span class="single-event__banner__subtitle-span">联系人:</span>
                        <strong>
                            {{ form.contact_person }}
                        </strong>
                        <br>
                        <span class="single-event__banner__subtitle-span">联系电话:</span>
                        <strong>
                            {{ form.contact_number }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            form: {
                type: Object,
                required: true
            },
            src: {
                type: String,
                required: true,
            }
        }
    }
</script>

<style lang="scss">
    .hero-body {
        &--overlay {
            position: relative;
            &:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: black;
                opacity: 0.3;
            };
        }
    }
    .single-event {
        &__banner {
            &__subtitle {
                @media (min-width: 768px) {
                    /*max-width: 45%;*/
                }
            }
            &__subtitle-span {
                display: inline-block;
                min-width: 80px;
            }
        }
    }
</style>
