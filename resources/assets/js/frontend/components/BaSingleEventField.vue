<template>
    <div class="field">
        <label class="label">{{ field.label }}</label>
        <div class="control">
            <input v-model="tempVar" v-if="field.type === 'input'" class="input" type="text" :placeholder="field.placeholder">
            <input v-model="tempVar" v-else-if="field.type === 'email'" class="input" type="email" :placeholder="field.placeholder">
            <textarea v-model="tempVar" v-else-if="field.type === 'textarea'" class="textarea" :placeholder="field.placeholder"></textarea>
            <b-field class="file" v-else-if="field.type === 'uploader'">
                <b-upload v-model="files" drag-drop>
                    <a class="button is-white">
                        <b-icon icon="upload" pack="fa"></b-icon>
                        <span>Click to upload</span>
                    </a>
                </b-upload>
                <span class="file-name"
                  v-if="files && files.length">
                    {{ files[0].name }}
                </span>
            </b-field>
            <b-datepicker v-model="tempVar" v-else-if="field.type === 'datepicker'" :placeholder="field.placeholder" icon="calendar-today"></b-datepicker>
            <b-timepicker v-model="tempVar" v-else-if="field.type === 'timepicker'" :placeholder="field.placeholder" icon="clock"></b-timepicker>
            <div class="field" v-else-if="field.type === 'checkbox'">
                <b-checkbox true-value="Yes" false-value="No" v-model="tempVar">
                    <a :href="field.link ? field.link : 'javascript:;'">
                        {{ field.label }}
                    </a>
                </b-checkbox>
            </div>
            <b-field v-else-if="field.type === 'dropdown'">
                <b-select :placeholder="field.placeholder" expanded class="field__select" v-model="tempVar">
                    <option :value="option" v-for="(option,i) in field.options" :key="i">{{ option }}</option>
                </b-select>
            </b-field>
            <div class="block" v-else-if="field.type === 'radio'">
                <b-radio :native-value="option" v-for="(option,i) in field.options" :key="i" v-model="tempVar">
                    {{ option }}
                </b-radio>
            </div>
        </div>
        <p class="help" v-if="field.instruction" v-text="field.instruction"></p>
        <p class="help" v-if="field.type === 'textarea' && field.allow_markdown">可以使用 <a class="help__markdown" target="_blank" href="https://sspai.com/post/25137">Markdown</a></p>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        props: {
            field: {
                type: Object,
                required: true
            }
        },
        data () {
            return {
                isFirst: true,
                dirty: false,
                tempVar: null,
                files: []
            }
        },
        watch: {
            tempVar (val) {
                this.onUpdateField(val);
            },
            files (val) {
                const formData = new FormData();

                if (!val.length) return;

                formData.append('upload_image', val[0], val[0].name);

                console.log(formData);

                this.onUpdateField(formData);
            }
        },
        methods: {
          ...mapActions('Events', [
              'createNewEventFieldRequest'
            ]),
            onUpdateField(val) {
              let data = {
                  field_value: val,
                  uuid: this.field.id,
              }
              this.$emit('change', data);
            }
        },
        mounted () {
            let self = this;
            if (this.field) {
                this.createNewEventFieldRequest({
                    field: self.field
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    input, textarea {
        border-radius: 0;
        box-shadow: none !important;
    }
    .field__select {
        span select, span, select, .select {
            border-radius: 0 !important;
            box-shadow: none !important;
        }
    }
    .help {
        &__markdown {
            text-decoration: underline;
        }
    }
</style>
