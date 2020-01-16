<template>
    <v-layout row wrap>
        <v-flex xs10 offset-xs1 class="common-use-btn abdef">
            <v-btn
                v-for="commonField in commonFields"
                :key="commonField.id"
                color="primary"
                class="same-btn-length"
                round
                small
                @click.native="addNewCard(commonField)">
                {{ commonField.label }}
                <v-icon right dark>{{commonField.icon}}</v-icon>
            </v-btn>
        </v-flex>
    </v-layout>
</template>

<script>
    import { mapActions } from 'vuex';
    import { uuid } from 'src/Uuid';
    export default {
        data () {
            return {
                commonFields: this.instantiate()
            }
        },
        methods: {
            ...mapActions('FormBuilder', [
                'pushFormField'
            ]),
            addNewCard (formField) {
                this.pushFormField({
                    form_field: formField
                }).then(response => {
                    this.$toasted.success(this.$t('FormBuilder.fileAdded'), {
                        duration: 2000
                    });
                });
                this.commonFields = this.instantiate();
            },

            instantiate () {
                return [
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.firstNameLabel'), icon: 'account_circle', type: 'input'},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.lastNameLabel'), icon: 'account_circle', type: 'input'},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.emailLabel'), icon: 'email', type: 'email'},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.selfIntroLabel'), icon: 'accessibility', type: 'textarea', allow_markdown: true},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.telephoneLabel'), icon: 'phone', type: 'input'},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.genderLabel'), icon: 'accessibility', type: 'radio', options: [this.$t('FormBuilder.genderMaleLabel'), this.$t('FormBuilder.genderFemaleLabel')]},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.addressLabel'), icon: 'home', type: 'input'},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.howToKnowUsLabel'), icon: 'question_answer', type: 'dropdown', options: [this.$t('FormBuilder.internetLabel'), this.$t('FormBuilder.newsLabel'), this.$t('FormBuilder.friendLabel')]},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.imageLabel'), icon: 'image', type: 'uploader', upload_type: 'image'},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.DateLabel'), icon: 'date_range', type: 'datepicker', constraint: ['weekend']},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.timeLabel'), icon: 'update', type: 'timepicker', constraint: []},
                    {id: uuid(), required: true, instruction: '', label: this.$t('FormBuilder.fileLabel'), icon: 'attach_file', type: 'uploader', upload_type: 'normal'}
                ];
            }
        },
        mounted () {
            // this.$api.getRoute('backend.form.common-fields').then(response => {
            //     if (response.commonFields) {
            //         this.commonFields = response.commonFields;
            //     }
            // });
        }
    }
</script>

<style lang="scss" scoped>
    /* This is for documentation purposes and will not be needed in your application */
    #create .speed-dial {
        position: absolute;
    }

    #create .btn--floating {
        position: relative;
    }
    .common-use-btn {
        min-width: 130px;
        color: white;
        button {
            color: white;
        }
    }
    .same-btn-length {
        min-width: 130px;
    }
</style>
