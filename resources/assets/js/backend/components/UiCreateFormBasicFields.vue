<template>
    <v-layout row wrap>
        <v-flex xs12 class="image-insert-link" v-if="currentFormBuilder.banner_link">
            <transition name="fade">
                <img class="image-insert-link__img" :src="usingGPhoto ? 'https://drive.google.com/uc?id=' + currentFormBuilder.banner_link : currentFormBuilder.banner_link">
            </transition>
        </v-flex>
        <v-flex xs4>
            <v-switch v-model="usingGPhoto" label="Banner image type" color="primary"></v-switch>
        </v-flex>
        <v-flex xs8 v-if="usingGPhoto">
            <v-text-field
                v-model="currentFormBuilder.banner_link"
                prepend-icon="image" label="Google Drive Image Share ID"
                persistent-hint
                hint="如何获取Google Drive Image ID: <a target='_blank' href='https://www.youtube.com/watch?v=Y1joksnUW04'>点击这里</a>">
            </v-text-field>
        </v-flex>
        <v-flex xs6 v-else>
            <v-text-field v-model="currentFormBuilder.banner_link" prepend-icon="link" label="Normal image link"></v-text-field>
        </v-flex>
        <v-flex xs6></v-flex>
        <!--<v-flex xs4>-->
            <!--<v-switch v-model="currentFormBuilder.is_upload_file" label="Or upload an image" color="primary">-->
            <!--</v-switch>-->
        <!--</v-flex>-->
        <v-flex xs12>
            <v-text-field
                prepend-icon="title"
                :label="$t('FormBuilder.formName')  + ' *'"
                :rules="[rules.required]"
                @update:error="receiveError"
                validate-on-blur
                v-model="currentFormBuilder.form_name"></v-text-field>
        </v-flex>
        <v-flex xs6 pr-2>
            <v-text-field
                v-model="currentFormBuilder.contact_person"
                :label="$t('FormBuilder.contacter')"
                prepend-icon="perm_contact_calendar"
                :hint="$t('FormBuilder.optional')">
            </v-text-field>
        </v-flex>
        <v-flex xs6 pl-2>
            <v-text-field v-model="currentFormBuilder.contact_number" :label="$t('FormBuilder.contactPhone')" :hint="$t('FormBuilder.optional')">
            </v-text-field>
        </v-flex>
        <v-flex xs12>
            <v-switch v-model="showTimeOption" color="primary" label="添加时间范围"></v-switch>
        </v-flex>
        <v-flex v-if="showTimeOption" xs6 pr-2>
            <!--start date-->
            <v-menu
                ref="menuStartDate"
                :close-on-content-click="false"
                v-model="menuStartDate"
                :return-value.sync="currentFormBuilder.start_date"
                lazy
                transition="scale-transition">
                <v-text-field
                    slot="activator"
                    prepend-icon="event"
                    v-model="currentFormBuilder.start_date"
                    :label="$t('FormBuilder.startDateLabel') + ' *'"
                    xs12
                    :rules="[rules.required, rules.hasDateErr]"
                    validate-on-blur
                    readonly>
                </v-text-field>
                <v-date-picker v-model="currentFormBuilder.start_date" @input="$refs.menuStartDate.save(currentFormBuilder.start_date)"></v-date-picker>
            </v-menu>
            <!--start time-->
            <v-menu
                ref="menuStartTime"
                :close-on-content-click="false"
                v-model="menuStartTime"
                :return-value.sync="currentFormBuilder.start_time"
                transition="scale-transition">
                <v-text-field
                    slot="activator"
                    v-model="currentFormBuilder.start_time"
                    :label="$t('FormBuilder.startTimeLabel') + ' *'"
                    required
                    validate-on-blur
                    :rules="[rules.required, rules.hasDateTimeErr]"
                    prepend-icon="access_time"
                    readonly>
                </v-text-field>
                <v-time-picker
                    v-if="menuStartTime"
                    format="24hr"
                    v-model="currentFormBuilder.start_time"
                    @change="$refs.menuStartTime.save(currentFormBuilder.start_time)">
                </v-time-picker>
            </v-menu>
        </v-flex>
        <v-flex v-if="showTimeOption" xs6 pl-2>
            <!--expired date-->
            <v-menu
                ref="menuExpiredDate"
                :close-on-content-click="false"
                v-model="menuExpiredDate"
                :return-value.sync="currentFormBuilder.expired_date"
                lazy
                transition="scale-transition">
                <v-text-field
                    slot="activator"
                    v-model="currentFormBuilder.expired_date"
                    :rules="[rules.required, rules.hasDateErr]"
                    validate-on-blur
                    prepend-icon="event"
                    :label="$t('FormBuilder.endDateLabel') + ' *'"
                    xs12
                    readonly>
                </v-text-field>
                <v-date-picker v-model="currentFormBuilder.expired_date" @input="$refs.menuExpiredDate.save(currentFormBuilder.expired_date)"></v-date-picker>
            </v-menu>
            <!--expired time-->
            <v-menu
                ref="menuExpiredTime"
                :close-on-content-click="false"
                v-model="menuExpiredTime"
                :return-value.sync="currentFormBuilder.expired_time"
                transition="scale-transition">
                <v-text-field
                    slot="activator"
                    v-model="currentFormBuilder.expired_time"
                    :label="$t('FormBuilder.endTimeLabel') + ' *'"
                    :rules="[rules.required, rules.hasDateTimeErr]"
                    validate-on-blur
                    prepend-icon="access_time"
                    readonly>
                </v-text-field>
                <v-time-picker
                    v-if="menuExpiredTime"
                    format="24hr"
                    v-model="currentFormBuilder.expired_time"
                    @change="$refs.menuExpiredTime.save(currentFormBuilder.expired_time)">
                </v-time-picker>
            </v-menu>
        </v-flex>
        <v-flex xs12>
            <v-textarea
                class="form-description"
                :label="$t('FormBuilder.formIntro')"
                rows="6"
                prepend-icon="description"
                mb-3
                v-model="currentFormBuilder.form_description">
            </v-textarea>
        </v-flex>
    </v-layout>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex';
    export default {
        data () {
            return {
                form: false,
                usingGPhoto: true,
                showTimeOption: false,
                menuStartDate: false,
                menuExpiredDate: false,

                menuStartTime: false,
                menuExpiredTime: false,

                showDatePicker1: false,
                showDatePicker2: false,
                showTimePicker1: false,
                showTimePicker2: false,
                rules: {
                    required: value => !!value || this.$t('FormBuilder.required'),
                    counter: value => value.length <= 20 || 'Max 20 characters',
                    email: value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'Invalid e-mail.'
                    },
                    hasDateErr: value => {
                        return this.hasDateError ? this.$t('FormBuilder.wrongStartDateErrorMsg'): true;
                    },
                    hasDateTimeErr: value => {
                        return this.hasDateTimeError ? this.$t('FormBuilder.wrongStartTimeErrorMsg'): true;
                    }
                }
            }
        },
        computed: {
            ...mapState('FormBuilder', [
                'currentFormBuilder',
            ]),
            ...mapGetters('FormBuilder', [
                'hasDateTimeError',
                'hasDateError'
            ]),
        },
        methods: {
            ...mapActions('FormBuilder', [
                'onChangeFormBuilderAttribute',
            ]),
            receiveError(val) {
                this.$emit('info-error', val);
            }
        },
    }
</script>

<style lang="scss" scoped>
    .image-insert-link {
        &__img {
            max-height: 385px;
            width:auto;
            max-width:100%;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }
    }
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
      opacity: 0;
    }
</style>
