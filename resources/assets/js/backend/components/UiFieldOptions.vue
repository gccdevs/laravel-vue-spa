<template>
    <v-layout row wrap ref="sidebarFormFields">
        <v-flex xs12>
            <v-btn label @click="toggleButton('showCommonFields')" hoverable color="error" class="hover-btn-group hover-btn-group--common">
                <v-icon v-if="!showCommonFields">add</v-icon>
                <v-icon v-else>remove</v-icon>
                {{ $t('FormBuilder.commonFields') }}
            </v-btn>
            <ui-common-form-field
                v-if="showCommonFields"
                :field="field1"
                class="hover-buttons hover-buttons--common"
                :color="'cyan'">
            </ui-common-form-field>
        </v-flex>
        <v-btn label @click="toggleButton('showCustomFields')" color="error" class="hover-btn-group hover-btn-group--custom">
            <v-icon v-if="!showCustomFields">add</v-icon>
            <v-icon v-else>remove</v-icon>
            {{ $t('FormBuilder.customOptions') }}
        </v-btn>
        <v-flex xs10 offset-xs1 ml-3 v-for="formType in formTypes" :key="formTypes.types" v-if="showCustomFields">
            <ui-form-field-popup :formFieldLabel="formType.label" :type="formType.type" :color="formType.color"></ui-form-field-popup>
        </v-flex>
    </v-layout>
</template>

<script>
    import { throttle } from 'lodash';
    export default {
        data () {
            return {
                showCommonFields: false,
                showCustomFields: false,
                field1: {
                    type: 'FIRST_NAME',
                    label: this.$t('FormBuilder.firstNameLabel'),
                    placeholder: 'Please enter your first name'
                },
                formTypes: [
                    {label: this.$t('FormBuilder.customInput'), type: 'input', color: 'primary'},
                    {label: this.$t('FormBuilder.customPicker'), type: 'picker',color: 'primary'},
                    {label: this.$t('FormBuilder.customDropdown'), type: 'dropdown',color: 'primary'},
                    {label: this.$t('FormBuilder.customCheckbox'), type: 'checkbox',color: 'primary'},
                    {label: this.$t('FormBuilder.customFileUpload'), type: 'uploader',color: 'primary'},
                ]
            }
        },
        methods: {
            toggleButton(buttonName) {
                if (buttonName === 'showCustomFields') {
                    this.showCustomFields = !this.showCustomFields;
                    this.showCommonFields = false;
                } else {
                    this.showCommonFields = ! this.showCommonFields;
                    this.showCustomFields = false;
                }
            }
        },
        mounted () {
            let sidebar = this.$refs['sidebarFormFields'];
            let self = this;
            window.addEventListener('scroll', throttle(function () {
                let windowOffset = 180;
                if (self.showCommonFields) {
                    windowOffset = 500;
                }
                if (window.scrollY >= (sidebar.offsetTop + windowOffset)) {
                    sidebar.classList.add(
                        'is-fixed-top'
                    )
                } else {
                    sidebar.classList.remove(
                        'is-fixed-top'
                    )
                }
            }), 400);
        }
    }
</script>

<style lang="scss" scoped>
    @import '~backend_variables';
    .is-fixed-top {
        position: fixed;
        top: 100px;
        z-index: 99;
        max-width: 190px;
    }
    .hover-btn-group {
        min-width: 180px;
    }
    .form-modules {
        min-height: 800px;
    }
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>