<template>
    <div fluid>
        <v-flex xs12>
            <!--<img class="form-banner-preview" :src="imagePreview" v-if="imagePreview"/>-->
            <v-text-field
                prepend-icon="add_to_photos"
                :label="$t('FormBuilder.formBgImg')" @click='pickFile' v-model='imageName'></v-text-field>
            <input
                type="file"
                style="display: none"
                ref="image"
                accept="image/*"
                @change="onFilePicked">
        </v-flex>
        <v-dialog v-model="dialog" max-width="290">
            <v-btn color="green darken-1" flat="flat" @click.native="dialog = false">关闭</v-btn>
        </v-dialog>
    </div>
</template>

<script>
    import { mapActions, mapState } from 'vuex';
    export default {
        data () {
            return {
                title: "Image Upload",
                dialog: false,
                imageName: '',
                imageFile: '',
                imagePreview: ''
            }
        },
        watch: {
            imagePreview (val) {
                this.imageUrl = val;
            },
            imageUrl (val) {
                if (!val || typeof val === 'undefined') {
                    this.imagePreview = val;
                    this.imageName = '';
                    this.imageFile = '';
                } else {
                    this.$store.commit('FormBuilder/setFormBuilderAttribute', {key: 'form_banner_name', value: this.imageName});
                }
            }
        },
        computed: {
            ...mapState('FormBuilder', [
                'currentFormBuilder',
            ]),
            imageUrl: {
                // getter
                get: function () {
                    return this.currentFormBuilder.form_banner;
                },
                // setter
                set: function (newValue) {
                    return this.$store.commit('FormBuilder/setFormBuilderAttribute', {key: 'form_banner', value: newValue});
                }
            }
        },
        methods: {
            ...mapActions('FormBuilder',[
                'onChangeFormBuilderAttribute'
            ]),
            pickFile () {
                this.$refs.image.click ()
            },

            onFilePicked (e) {
                const files = e.target.files
                if(files[0] !== undefined) {
                    this.imageName = files[0].name
                    if(this.imageName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader ()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.imagePreview = fr.result;
                        this.imageFile = files[0];
                    })
                } else {
                    this.imageName = '';
                    this.imageName = '';
                    this.imagePreview = '';
                }
            }
        }
    }
</script>

<style lang="scss">
    .form-banner-preview {
        background-size: contain;
        max-width: 100%;
        max-height: 385px;
    }
</style>
