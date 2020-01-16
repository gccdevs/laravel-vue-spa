<template>
    <v-container>
        <v-layout pt-3 pb-3>
            <v-flex xs1><v-btn round color="primary" :to="{name: 'admin.form.list'}"><v-icon>arrow_back</v-icon>{{ $t('FormBuilder.goBackLabel') }}</v-btn></v-flex>
            <v-flex xs11></v-flex>
        </v-layout>
        <v-tabs centered color="primary" icons-and-text dark v-if="!isLoading">
            <v-tabs-slider color="white"></v-tabs-slider>
            <v-tab href="#tab-1">
                {{ createForm ? $t('FormBuilder.createFormLabel') : $t('FormBuilder.editFormLabel')}}
                <v-icon>developer_board</v-icon>
            </v-tab>
            <v-tab href="#tab-2" v-if="!noResponse">
                {{ $t('FormBuilder.responseLabel') }}
                <v-icon>question_answer</v-icon>
            </v-tab>
            <v-tab-item v-for="i in 2" :id="'tab-' + i" :key="i">
                <div class="form-preselect page-builder" container v-if="i === 1">
                    <ui-form-builder-stepper></ui-form-builder-stepper>
                </div>
                <div class="form-preselect page-builder" container v-if="i === 2">
                    <ui-form-builder-response></ui-form-builder-response>
                </div>
            </v-tab-item>
        </v-tabs>
    </v-container>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex';
    export default {
        data () {
            return {
                noResponse: false,
                createForm: false,
                isLoading: true,
            }
        },
        mounted () {
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.noResponse = false;
                this.createForm = false;

                this.$api.getRoute('backend.form.single', {id: id}, {}).then(response => {
                    this.isLoading = false;
                    if (response.data.data) {
                        let currentFormBuilder = response.data.data;
                        console.log(currentFormBuilder)
                        this.batchUpdate({currentFormBuilder: currentFormBuilder});
                    } else {
                        this.noResponse = true;
                        this.createForm = true;                        
                    }
                }).catch(err => {
                    this.isLoading = false;                    
                });
            } else {
                this.isLoading = false;
                this.noResponse = true;
                this.createForm = true;
            }
        },        
        methods: {
            ...mapActions('FormBuilder', [
                'batchUpdate'
            ])
        }
    }
</script>

<style lang="scss">

    @media screen and (max-width: 991px) {
        .page-builder {
            /*display: none;*/
        }
        .page-banner {
            display: block;
        }
    }

    .page-banner {
        display: none;
    }

    .form-description {
        .input-group__input {
            textarea {
                resize: none;
            }
        }
    }

    .form-builder-panel {
        min-height: 150px;
    }


</style>
