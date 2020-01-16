<template>
    <v-layout justify-center>
        <v-flex row pt-3 pb-5 justify-center class="text-sm-center">
            <v-btn xs12 color="primary" @click="onSave" round :disabled="hasErr
             || isOnSubmitting" :loading="isOnSubmitting">完成</v-btn>
<!--             <v-btn xs12 color="primary" @click="onPreview" round :disabled="hasErr || isOnSubmitting" :loading="isOnSubmitting">{{ $t('FormBuilder.formPreview') }}</v-btn> -->
            <!--<v-btn xs12 color="warning" dark @click="onSaveDraft" round>{{ $t('FormBuilder.saveDraft') }}</v-btn>-->
<!--             <v-btn xs12 color="error" @click="onClean" :disabled="isOnSubmitting" round>{{ $t('FormBuilder.restart') }}</v-btn> -->
        </v-flex>
        <v-dialog v-model="isOnSubmitting" hide-overlay persistent width="300">
            <v-card color="primary" dark>
                <v-card-text>
                    Please stand by
                    <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex';
    import { decimalPlaces } from 'backendUtils/AmountDecimals';

    export default {
        data () {
            return {
                isOnSubmitting: false
            }
        },
        props: {
            hasError: {
                type: Boolean,
                required: true,
            },
            submitType: {
                type: String,
                default: 'SUBMIT'
            }
        },
        computed: {
            ...mapState('FormBuilder', [
                'currentFormBuilder',
            ]),
            ...mapGetters('User', [
                'getUser',
            ]),
            hasErr() {
                if (this.hasError) {{
                    return true;
                }}
                if (this.currentFormBuilder.has_payment) {
                    if (!this.currentFormBuilder.payment.amount ||
                        parseFloat(this.currentFormBuilder.payment.amount) <= 0 ||
                        isNaN(this.currentFormBuilder.payment.amount) ||
                        decimalPlaces(parseFloat(this.currentFormBuilder.payment.amount)) > 2) {
                        return true;
                    }
                }
                return false;
            }
        },
        methods: {
            onSave () {
                let self = this;
                this.isOnSubmitting = true;
                let data = this.currentFormBuilder;
                data.is_draft = true;
                let route = self.submitType === 'SUBMIT' ? 'backend.form.create' : 'backend.form.edit';
                self.$api.postRoute(route, {}, {data}).then(response => {  
                    self.isOnSubmitting = false;
                    if (response.data.status) {
                        self.$store.dispatch('FormBuilder/clearFormBuilder').then(response => {
                            self.$emit('saved');
                        });
                    } else {
                        self.$toasted.error(this.$t('FormBuilder.formCreatedErrorLabel'), {
                            icon: 'sms_failed' 
                        });
                    }
                }).catch(error => {
                    self.isOnSubmitting = false;
                    self.$toasted.error(error, {
                        icon: 'error'
                    });
                });
            },
            onClean () {
                this.$store.dispatch('FormBuilder/clearFormBuilder').then(response => {});
            },
            onPreview () {
                this.isOnSubmitting = true;
            }
        }
    }
</script>

<style>

</style>
