<template>
    <v-card @mouseenter="isOnHover = true" @mouseleave="isOnHover = false"
        min-height="280px" elevation-3 hover
        class="form-card">
        <v-img :src="imageSrc" height="180px"></v-img>
        <v-card-text>
            <div>{{ form.form_name }}</div>
            <div>
                <div class="label">
                    {{ $t('FormBuilder.createdByLabel') }}:
                </div>
                <div class="value">
                    {{ form.author.name }}
                </div>
                <br>
                <div class="label">
                    {{$t('FormBuilder.expiredAtLabel')}}:
                </div>
                <div class="value">
                    {{ form.expired_date }}
                </div>
            </div>
        </v-card-text>
        <transition name="fade">
            <div class="form-card__overlay" v-if="isOnHover">
                <v-btn class="form-card__share" fab :outline="isOnShare" small dark @mouseenter="isOnShare = true" @mouseleave="isOnShare = false" @click="doCopy"><v-icon>share</v-icon></v-btn>
                <v-btn round color="primary" class="form-card__btn" :to="{name: 'admin.form.edit', params: {id: form.id}}">{{ $t('FormBuilder.viewFormLabel') }}</v-btn>
            </div>
        </transition>
    </v-card>
</template>

<script>
    export default {
        props: {
            form: {
                required: true,
                type: Object
            }
        },
        data () {
            return {
                isOnHover: false,
                isOnShare: false,
            }
        },
        computed: {
            imageSrc () {
                let str = this.form.banner_link;
                if (str) {
                    if (str.startsWith('http://') || str.startsWith('https://') || str.startsWith('www.')) {
                        return str;
                    }
                    return 'https://drive.google.com/uc?id=' + this.form.banner_link;
                }
                return 'https://images.unsplash.com/photo-1532140225690-f6d25ab4c891?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=84cce292e58788c4a0f7e847dd88b490&auto=format&fit=crop&w=3150&q=80';
            },
            shareLink () {
                return Laravel.APP_URL + '/events/' + this.form.id;
            }
        },
        methods: {
            doCopy: function () {
                let self = this;
                self.$copyText(self.shareLink).then(function (e) {
                    console.log('Copied: ' + e.text);
                    self.$toasted.success('Share link copied!');
                }, function (e) {
                })
            }
        },
        mounted () {
        }
    }
</script>

<style lang="scss" scoped>
    .form-card {
        position: relative;
        max-width: 350px;
        &__overlay {
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            position: absolute;
            background-color: rgba(0,0,0, 0.4);
        }
        &__share {
            padding-right: 5px;
            float: right;
            color: white;
        }
        &__btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .label, .value {
            min-width: 75px;
            display: inline-block;
        }
        .value {
            font-weight: 500;
        }
    }
</style>
