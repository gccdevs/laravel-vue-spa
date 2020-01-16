<template>
    <v-layout row>
        <v-dialog v-model="dialog" persistent max-width="500px">
            <v-btn
                class="custom-form-btn"
                slot="activator" 
                round
                small
                :color="color">
                {{ formFieldLabel }}
            </v-btn>
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('FormBuilder.CustomFieldPopup') }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12>
                                <v-text-field :label="$t('FormBuilder.fieldName')" v-model="formField.label" required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    :label="$t('FormBuilder.required')"
                                    color="primary"
                                    v-model="formField.required"
                                ></v-switch>
                            </v-flex>
                            <v-flex xs12>
                                <v-select
                                    :label="$t('FormBuilder.fieldType')"
                                    v-if="type === 'input'"
                                    v-model="formField.type"
                                    required
                                    :items="inputTypes"
                                    item-text="label"
                                    item-value="value">
                                </v-select>
                                <v-select
                                    :label="$t('FormBuilder.fieldFileType')"
                                    v-if="type === 'uploader'"
                                    v-model="formField.upload_type"
                                    required
                                    :items="uploaderTypes"
                                    item-text="label"
                                    item-value="value">
                                </v-select>
                                <v-select
                                    :label="$t('FormBuilder.fieldType')"
                                    v-if="type === 'dropdown'"
                                    v-model="formField.type"
                                    required
                                    :items="dropdownTypes"
                                    item-text="label"
                                    item-value="value">
                                </v-select>
                                <v-select
                                    :label="$t('FormBuilder.fieldType')"
                                    v-if="type === 'picker'"
                                    v-model="formField.type"
                                    required
                                    :items="pickerTypes"
                                    item-text="label"
                                    item-value="value">
                                </v-select>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch color="primary"
                                    v-if="type === 'input' && formField.type === 'textarea'" :label="$t('FormBuilder.allowMarkdown')" v-model="formField.allowMarkdown">
                                </v-switch>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field :label="$t('FormBulder.fieldType')"  value="Checkbox" disabled v-if="type === 'checkbox'"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <small>{{ $t('FormBuilder.RequiredHintLabel') }}</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click.native="dialog = false">{{ $t('FormBuilder.popupClose') }}</v-btn>
                    <v-btn color="blue darken-1" flat @click.native="onSave">{{ $t('FormBuilder.popupConfirm') }}</v-btn>
                </v-card-actions>
            </v-card>
            <v-alert
                    :value="alert"
                    @input="changeAlert"
                    type="error"
                    transition="scale-transition"
                    dismissible>
                {{ errorMsg }}
            </v-alert>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { mapActions } from 'vuex';
    import { uuid } from 'src/Uuid';
    export default {
        data () {
            return {
                alert: false,
                errorMsg: null,
                is_field_required: false,
                dialog: false,
                inputTypes: [
                    {
                        label: this.$t('FormBuilder.shortInputLabel'),
                        value: 'input'
                    },
                    {
                        label: this.$t('FormBuilder.longInputLabel'),
                        value: 'textarea'
                    }
                ],
                dropdownTypes: [
                    {
                        label: this.$t('FormBuilder.dropdownLabel'),
                        value: 'dropdown'
                    },
                    {
                        label: this.$t('FormBuilder.radioLabel'),
                        value: 'radio'
                    }
                ],
                pickerTypes: [
                    {
                        label: this.$t('FormBuilder.datePickerLabel'),
                        value: 'datepicker'
                    },
                    {
                        label: this.$t('FormBuilder.timePickerLabel'),
                        value: 'timepicker'
                    }
                ],
                uploaderTypes: [
                    {
                        label: this.$t('FormBuilder.imageLabel'),
                        value: 'image'
                    },
                    {
                        label: this.$t('FormBuilder.videoLabel'),
                        value: 'video'
                    },
                    {
                        label: this.$t('FormBuilder.fileLabel'),
                        value: 'normal'
                    },
                ],
                formField: {
                    id: uuid(),
                    label: null,
                    instruction: null,
                    type: null,
                }
            }
        },
        props: {
            formFieldLabel: {
                required: true,
                type: String
            },
            type: {
                type: String,
                default: null
            },
            color: {
                type: String,
                default: 'primary'
            }
        },
        methods: {
            ...mapActions('FormBuilder', [
                'pushFormField'
            ]),
            onSave () {
                if (!this.formField.label) {
                    this.errorMsg = this.$t('FormBuilder.missingName');
                    this.alert = true;
                    return;
                } else {
                    this.alert = false;
                }

                if (!this.formField.type) {
                    this.errorMsg = this.$t('FormBuilder.missingType');
                    this.alert = true;
                    return;
                } else {
                    this.alert = false;
                }

                this.dialog = false;
                this.pushFormField({
                    form_field: this.formField
                }).then(response => {
                    this.$toasted.success('New field added!', {
                        duration: 2000
                    });
                });
                this.formField = {
                    id: uuid()
                };
                this.alert = false;
                this.errorMsg = null;
            },
            changeAlert (value) {
                this.alert = false;
                this.errorMsg = null;
            }
        },
        mounted() {
            if (this.type === 'checkbox') {
                this.formField.type = 'checkbox';
            } else if (this.type === 'uploader') {
                this.formField.type = 'uploader';
            }
        }
    }
</script>

<style lang="scss">
    .custom-form-btn {
        width: 100%;
        min-width: 140px;
        text-align: center !important;
        color: white;
    }
</style>