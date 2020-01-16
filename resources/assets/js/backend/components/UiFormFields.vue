<template>
    <div v-if="formField" class="form-field">
        <v-card class="form-field__single" hover>
            <span class="form-field__remove" @click="removeCard(formField)" @mouseenter="isOnHover = true" @mouseleave="isOnHover = false">
                <v-icon class="" v-if="!isOnHover">remove_circle_outline</v-icon>
                <v-icon class="" v-else>cancel</v-icon>
            </span>
            <span class="form-field__collapse" @click="collapseCard">
                <v-icon v-if="isCollapsed">keyboard_arrow_up</v-icon>
                <v-icon v-else>keyboard_arrow_down</v-icon>
            </span>
            <div class="form-field__label" @click="collapseCard">{{ $t('FormBuilder.' + formField.type) }} <span v-if="isCollapsed">({{ shortDescription(formField.label) }})</span> </div>
            <transition name="component-fade" mode="out-in">
                <v-layout wrap v-if="!isCollapsed">
                    <v-flex style="width: fit-content">
                        <v-switch
                            v-model="formField.required"
                            color="primary"
                            :label="$t('FormBuilder.required')">
                        </v-switch>
                        <v-switch
                            v-model="formField.allow_markdown"
                            color="primary"
                            v-if="formField.type === 'textarea'"
                            :label="$t('FormBuilder.allowMarkdown')">
                        </v-switch>
                        <v-text-field
                            :label="$t('FormBuilder.fieldName') + '*'"
                            :rules="[rules.required]"
                            @update:error="receiveError"
                            validate-on-blur
                            v-model="formField.label">
                        </v-text-field>
                        <v-text-field
                                :label="$t('FormBuilder.otherDescription')"
                                v-model="formField.instruction">
                        </v-text-field>
                        <v-text-field
                            :label="$t('FormBuilder.placeholder')"
                            v-if="formField.type !== 'checkbox' && formField.type !== 'radio' && formField.type !== 'payment'"
                            v-model="formField.placeholder">
                        </v-text-field>
                        <v-text-field
                            v-if="formField.type === 'checkbox'"
                            :label="$t('FormBuilder.otherDescription')"
                            v-model="formField.description">
                        </v-text-field>
                        <v-text-field
                            v-if="formField.type === 'checkbox'"
                            :label="$t('FormBuilder.link')"
                            v-model="formField.link">
                        </v-text-field>
                        <v-switch
                            v-model="formField.multiple"
                            v-if="formField.type === 'dropdown'"
                            color="primary"
                            :label="$t('FormBuilder.allowMultiple')">
                        </v-switch>
                        <v-select
                            :label="$t('FormBuilder.fileLabel')"
                            v-if="formField.type === 'uploader'"
                            v-model="formField.upload_type"
                            required
                            :items="uploaderTypes"
                            item-text="label"
                            item-value="value">
                        </v-select>
                        <ui-editing-options
                            v-if="formField.type === 'dropdown' || formField.type === 'radio'"
                            :formField="formField">
                        </ui-editing-options>
                        <ui-editing-options
                            v-if="formField.type === 'datepicker' || formField.type === 'timepicker'"
                            :formField="formField">
                        </ui-editing-options>
                        <!--<ui-editing-payment :formField="formField" v-if="formField.type === 'payment'"></ui-editing-payment>-->
                    </v-flex>
                </v-layout>
            </transition>
        </v-card>
    </div>
</template>

<script>
    import { getFormFieldType } from 'src/Form-field-type.js';
    import { mapActions } from 'vuex';
    import draggable from 'vuedraggable';
    export default {
        data () {
            return {
                rules:{
                    required: value => !!value || this.$t('FormBuilder.required'),
                },
                isOnHover: false,
                isCollapsed: false,
                uploaderTypes: [
                    {
                        label: 'Image',
                        value: 'image'
                    },
                    {
                        label: 'Video',
                        value: 'video'
                    },
                    {
                        label: 'General Document',
                        value: 'normal'
                    },
                ],
                logic: {},
                showConditionalLogic: false
            }
        },
        props: {
            formField: {
                type: Object,
                required: true
            }
        },
        components: {
            draggable
        },
        methods: {
            ...mapActions('FormBuilder', [
                'removeFormField'
            ]),
            shortDescription (name) {
                if (name && name.length > 0) {
                    return name.substr(0,6);
                }
                return 'Err!';
            },
            receiveError(val) {
                if (val) {
                    this.$emit('input-error', this.formField);
                } else {
                    this.$emit('input-error', false);                    
                }
            },
            removeCard (formField) {
                this.removeFormField({form_field: formField});
            },
            collapseCard () {
                this.isCollapsed = !this.isCollapsed;
            }
        },
        mounted () {
        }
    }
</script>

<style lang="scss" scoped>
    .form-field {
        height: auto;
        &__label {
            text-transform: uppercase;
            text-align: left;
            font-size: 24px;
            font-weight: bold;
        }
        &__sub-label {
            font-size: 14px;
            color: rgb(165, 165, 165);
        }
        &__single {
            padding: 15px;
            width: 380px;
        }
        &__attribute {
            float: left;
            margin-left: 0;
        }
        &__remove {
            z-index: 1;
            float: right;
            font-weight: bold;
            &:hover {
                content: 'remove_circle_outline';
            }
        }

        &__collapse {
            display: block;
            padding-right: 10px;
            float: right;
            font-weight: bold;
            z-index: 2;
        }

        &:hover {
            .form-field__remove {
                z-index: 1;
                content: 'remove_circle_outline';
            }
        }
    }
    .component-fade-enter-active, .component-fade-leave-active {
        transition: opacity .2s ease;
    }
    .component-fade-enter, .component-fade-leave-to
        /* .component-fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
